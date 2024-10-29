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
        ->withCount('comments')
        ->withCount('likes')
        ->orderByRaw("FIELD(user_id, " . implode(',', $followingIds) . ") DESC") // Priorité aux utilisateurs suivis, gros merci chatgpt
        ->orderByDesc('likes_count')
        ->orderByDesc('published_at')
        ->paginate(12)
        ->withQueryString(); //conserve la recherche à travers la pagination

    return view('feed.index', [
        'users' => $users,
        'posts' => $posts,
    ]);
}

}
