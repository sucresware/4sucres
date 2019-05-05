<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public $with = 'parents';

    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function parents()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order', 'asc');
    }
}