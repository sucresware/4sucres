<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];

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
        if (!auth()->user()->can('use restricted categories')) {
            return $query->where('restricted', false);
        } else {
            return $query;
        }
    }
}
