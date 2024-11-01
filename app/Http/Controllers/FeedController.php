<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(Request $request)
{
    $searchTerm = $request->query('search'); //string de la barre de recherche
    $user = Auth::user();

    // Récupérer les ID des utilisateurs suivis par l'utilisateur connecté
    $followingIds = $user ? $user->following()->pluck('users.id')->toArray() : [];

    // Rechercher les utilisateurs correspondant au terme 'search' dans `username`
    $users = User::query()
        ->when($searchTerm, function ($query) use ($searchTerm) //quand on tape quelque chose dans la barre on entre dans la condition
        {
            $query->where('username', 'LIKE', '%' . $searchTerm . '%'); //là où username ressemble au string dans la barre de recherche
        })
        ->get(); //ca fait select dans la DB


    // Récupérer les posts associés aux utilisateurs trouvés ou contenant le mot-clé dans `body`
    $posts = Post::query()
        ->when($searchTerm, function ($query) use ($users, $searchTerm) //quand on tape quelque chose dans la barre on entre dans la condition
        {
            $query->where(function ($query) use ($users, $searchTerm) //Cela définit une sous-requête qui va encapsuler plusieurs conditions.
            {
                $query->whereIn('user_id', $users->pluck('id')) //Where user_id in users filtrés
                      ->orWhere('body', 'LIKE', '%' . $searchTerm . '%'); //or where body like string dans la barre de recherche
            });
        })
        ->with('user')
        ->withCount('comments')
        ->withCount('likes')
        ->orderByRaw(
            count($followingIds) > 0
                ? "(
                    IF(user_id IN (" . implode(',', $followingIds) . "),
                        IF((SELECT COUNT(*) FROM likes WHERE post_id = posts.id AND user_id = " . Auth::id() . ") > 0, 1, 2),
                        3
                    )
                ) ASC, likes_count DESC, published_at DESC"
                : 'likes_count DESC'
                // Si l’utilisateur actuel a liké le post d’un utilisateur suivi, il obtient la priorité 1. Si l’utilisateur suivi n’a pas reçu de like de l’utilisateur actuel, il obtient la priorité 2.Les autres posts reçoivent une priorité 3.

        ) // Cela permet aux posts likés des personnes suivies d'apparaître en premier, suivis des autres posts des personnes suivies, puis des posts restants triés par popularité et date. MERCI CHATGPT
        ->orderByDesc('likes_count')
        ->orderByDesc('published_at')
        ->paginate(12)
        ->withQueryString(); //conserve la recherche à travers la pagination

    return view('feed.index', [
        'posts' => $posts,
        // 'users' => $users,
        'followingIds' => $followingIds,
    ]);
}

}
