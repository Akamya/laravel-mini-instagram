<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (){
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::patch('/profile/bio', [ProfileController::class, 'updateBio'])->name('profile.bio.update');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/posts/{post}/comments', [PostController::class, 'addComment'])->name('front.posts.comments.add');
    Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'deleteComment'])->name('front.posts.comments.delete');

    Route::post('/like/posts/{post_id}', [LikeController::class, 'likePost'])->name('front.posts.like.add');
    Route::delete('/like/posts/{post_id}', [LikeController::class, 'unlikePost'])->name('front.posts.like.delete');

    Route::post('/follow/users/{user_id}', [FollowController::class, 'follow'])->name('profile.show.follow');
    Route::delete('/follow/users/{user_id}', [FollowController::class, 'unfollow'])->name('profile.show.unfollow');

    Route::resource('posts', PostController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [FeedController::class, 'index'])->name('feed');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('front.posts.show');



//J'ai dû changé l'ordre de mes routes (le middleware auth en 1er) car il y a une IMPORTANCE de PRIORITE des routes surtout quand on utilise des paramètres dynamiques dans les URL (dans mon cas: posts/{id} et posts/create).
//Laravel pensait que mon create était un ID... Donc erreur 404 :)

require __DIR__.'/auth.php';
