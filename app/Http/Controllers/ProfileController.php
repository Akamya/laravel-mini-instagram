<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function updateAvatar(Request $request): RedirectResponse
{
    // Validation de l'image sans passer par une form request
    $request->validate([
        'pdp' => ['required', 'image', 'max:2048'],
    ]);

    // Si l'image est valide, on la sauvegarde
    if ($request->hasFile('pdp')) {
        $user = $request->user();
        $path = $request->file('pdp')->store('avatars', 'public');
        $user->pdp = $path;
        $user->save();
    }

    return Redirect::route('profile.edit')->with('status', 'avatar-updated');
}

/**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Trouve user
        $user = User::with('followers', 'following')
        ->findOrFail($id);

        // Trouve les posts de user
        $posts = Post::query()
        ->where('user_id', '=', $id)
        ->withCount('comments')
        ->withCount('likes')
        ->orderByDesc('published_at')
        ->paginate(12);

        // Les commentaires de l'utilisateur triés par date de création
        $comments = $user
        ->comments()
        ->orderByDesc('created_at')
        ->get();

        // Compte le nombre de followers pour ce user
        $followersCount = $user->followers()->count();

        // Vérifie si l'utilisateur connecté a déjà follow ce user
        $isFollowing = $user->followers()->where('follower_id', Auth::id())->exists();

        // Va vers la vue profile show avec le user et ses posts
        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
            'comments' => $comments,
            'followersCount' => $followersCount,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function updateBio(Request $request): RedirectResponse
{
    // Validation de la bio sans passer par une form request
    $request->validate([
        'bio' => ['required', 'string', 'max:300'],
    ]);

    // Si la bio est valide, on la sauvegarde
    if ($request->has('bio')) {
        $user = $request->user();
        $user->bio = $request->input('bio'); // Assignation de la biographie
        $user->save();
    }

    return Redirect::route('profile.edit')->with('status', 'bio-updated');
}
}
