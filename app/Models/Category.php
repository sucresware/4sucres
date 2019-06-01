<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    const ANNOUNCES_CATEGORY_ID = 1;
    const SHITPOST_CATEGORY_ID = 5;

    protected $casts = [
        'can_post' => 'array',
        'can_view' => 'array',
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
        return $query->orderBy('order');
    }

    public function scopeFiltered($query)
    {
        if (!user()->can('use restricted categories')) {
            return $query->where('restricted', false);
        } else {
            return $query;
        }
    }
}
