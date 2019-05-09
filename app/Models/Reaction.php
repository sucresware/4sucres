<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_reaction_user')->withPivot('user_id');
    }
}
