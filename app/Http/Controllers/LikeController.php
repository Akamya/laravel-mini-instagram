<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LikeController extends Controller
{
    public function likePost($id){

        // On crée un nouveau like
        $like = Like::make();

        // On ajoute les propriétés du like
        $like->post_id = $id;
        $like->published_at = date('Y-m-d H:i:s');
        $like->user_id = Auth::id();

        $like->save();

        return redirect()->back();
    }

    public function unlikePost($post_id){

        $like = Like::query()
        ->where('user_id', '=', Auth::id())
        ->where('post_id', '=', $post_id)
        ->first();

        // On vérifie que l'utilisateur à le droit de supprimer le like
        Gate::authorize('delete', $like);

        // On supprime le like
        $like->delete();

        // On redirige vers la page du post
        return redirect()->back();
    }
}
