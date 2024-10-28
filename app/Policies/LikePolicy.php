<?php

namespace App\Policies;

use App\Models\Like;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LikePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    public function delete(User $user, Like $like)
    {

        // Seul l'administateur ou le créateur du like peut supprimer un like
        return \App\Models\Role::ADMIN === $user->role->name || $user->id === $like->user_id;
    }
}
