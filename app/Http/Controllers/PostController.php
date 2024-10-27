<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

// Log::info() pour voir logs dans storage/logs/laravel.log

class PostController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    // On récupère l'article et on renvoie une erreur 404 si l'article n'existe pas
    $post = Post::findOrFail($id);
    // On récupère les commentaires de l'article, avec les utilisateurs associés (via la relation)
    // On les trie par date de création (le plus ancien en premier)
    $comments = $post
        ->comments()
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->get()
    ;

    // On renvoie la vue avec les données
    return view('front.posts.show', [
        'post' => $post,
        'comments' => $comments,
    ]);
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Requête SQL pour afficher les posts de l'utilisateur.
        $posts = Post::query()
        ->where('user_id', '=', Auth::id())
        ->orderByDesc('updated_at')
        ->paginate(10);

        return view(
            'posts.index',
            [
                'posts' => $posts,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        // On crée un nouveau post
        $post = Post::make();

        // On ajoute les propriétés du post
        $post->img_path = $request->validated()['img_path'];
        $post->body = $request->validated()['body'];
        $post->published_at = date('Y-m-d H:i:s');
        $post->user_id = Auth::id();

        // Si il y a une image, on la sauvegarde
        if ($request->hasFile('img_path')) {
            $path = $request->file('img_path')->store('posts', 'public');
            $post->img_path = $path;
        }

        // On sauvegarde l'article en base de données
        $post->save();

        //return view('posts.index');
        return redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
{
    // Log::info($request);
    // Vérifie si une nouvelle image a été fournie
    if ($request->hasFile('img_path')) {
        // Log::info('cc2');
        // Gérer l'upload de la nouvelle image
        $path = $request->file('img_path')->store('posts', 'public'); // Stocker l'image
        $post->img_path = $path; // Mettre à jour avec le chemin de la nouvelle image
    }
    // Log::info('cc3');

    // Met à jour les autres champs
    $post->body = $request->validated()['body'];

    $post->save(); // Sauvegarde les modifications

    return redirect()->route('posts.index')->with('success', 'Post mis à jour avec succès !');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back();
    }

    public function addComment(Request $request, Post $post)
{
    // On vérifie que l'utilisateur est authentifié
    $request->validate([
        'body' => 'required|string|max:2000',
    ]);

    // On crée le commentaire
    $comment = $post->comments()->make();
    // On remplit les données
    $comment->body = $request->input('body');
    $comment->user_id = Auth::user()->id;
    // On sauvegarde le commentaire
    $comment->save();

    // On redirige vers la page de l'article
    return redirect()->back();
}

public function deleteComment(Post $post, Comment $comment)
{
    // On vérifie que l'utilisateur à le droit de supprimer le commentaire
    Gate::authorize('delete', $comment);

    // On supprime le commentaire
    $comment->delete();

    // On redirige vers la page de l'article
    return redirect()->back();
}
}
