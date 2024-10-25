<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Log::info() pour voir logs dans storage/logs/laravel.log

class PostController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('front.posts.show', [
            'post' => $post,
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
}
