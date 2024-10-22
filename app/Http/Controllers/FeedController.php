<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    // Affiche les posts sur la page feed avec un paginate.
    public function index()
    {
        $posts = Post::paginate(12);

        return view('feed.index', [
            'posts' => $posts,
        ]);


    }
}
