<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    const CATEGORY_ANNOUNCES = 1;
    const CATEGORY_GLOBAL = 2;
    const CATEGORY_SHITPOST = 5;

    protected $casts = [
        'can_post' => 'array',
        'can_view' => 'array',
        'can_reply' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($category) {
            $category->slug = Str::slug($category->name);

            return $category;
        });
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function scopeOrdered($query)
    {
        return $query
            ->orderBy('order')
            ->orderBy('name');
    }

    public static function viewables()
    {
        return self::ordered()->get()->reject(function ($category) {
            return ! $category->canView(user());
        });
    }

    public static function postables()
    {
        return self::ordered()->get()->reject(function ($category) {
            return ! $category->canPost(user());
        });
    }

    public static function replyable()
    {
        return self::ordered()->get()->reject(function ($category) {
            return ! $category->canReply(user());
        });
    }

    public function canView($user)
    {
        $auth = true;

        if (auth()->check()) {
            if ($this->can_view) {
                $auth = in_array($user->roles[0]->name, $this->can_view);
            }

            $min_date = now()->subYears(18);

            if ($this->nsfw && (user()->dob && user()->dob->isAfter($min_date))) {
                $auth = false;
            }
        } else {
            $auth = ($this->can_view == null && ! $this->nsfw);
        }

        return $auth;
    }

    public function canPost($user)
    {
        $auth = true;

        if (auth()->check()) {
            if ($this->can_post) {
                $auth = in_array($user->roles[0]->name, $this->can_post);
            }

            $min_date = now()->subYears(18);

            if ($this->nsfw && (user()->dob && user()->dob->isAfter($min_date))) {
                $auth = false;
            }
        } else {
            $auth = ($this->can_post == null && ! $this->nsfw);
        }

        return $auth;
    }

    public function canReply($user)
    {
        $auth = true;

        if (auth()->check()) {
            if ($this->can_reply) {
                $auth = in_array($user->roles[0]->name, $this->can_reply);
            }

            $min_date = now()->subYears(18);

            if ($this->nsfw && (user()->dob && user()->dob->isAfter($min_date))) {
                $auth = false;
            }
        } else {
            $auth = ($this->can_reply == null && ! $this->nsfw);
        }

        return $auth;
    }
}
