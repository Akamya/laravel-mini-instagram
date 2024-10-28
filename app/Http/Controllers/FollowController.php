<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FollowController extends Controller
{
    public function follow($user_id)
{
    $userToFollow = User::findOrFail($user_id);

    // Vérifie que l'utilisateur connecté ne suit pas déjà l'utilisateur cible
    if (!Auth::user()->following()->where('followed_id', $user_id)->exists()) {
        Auth::user()->following()->attach($userToFollow);
    }

    return redirect()->back()->with('success', 'Vous suivez maintenant cet utilisateur.');
}

public function unfollow($user_id)
{
    $userToUnfollow = User::findOrFail($user_id);

    // Vérifie que l'utilisateur connecté suit bien l'utilisateur cible
    if (Auth::user()->following()->where('followed_id', $user_id)->exists()) {
        Auth::user()->following()->detach($userToUnfollow);
    }

    return redirect()->back()->with('success', 'Vous ne suivez plus cet utilisateur.');
}

}
