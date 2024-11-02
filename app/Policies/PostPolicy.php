<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function delete(User $user, Post $post)
    {

        // Seul l'administateur ou le créateur du post peut supprimer un post
        return \App\Models\Role::ADMIN === $user->role->name || $user->id === $post->user_id;
    }

    public function edit(User $user, Post $post)
    {

        // Seul l'administateur ou le créateur du post peut edit un post
        return \App\Models\Role::ADMIN === $user->role->name || $user->id === $post->user_id;
    }
}
