<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    /** @use HasFactory<\Database\Factories\FollowFactory> */
    use HasFactory;

    // Utilisateur qui suit
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    // Utilisateur suivi
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
