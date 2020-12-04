<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $incrementing = false;

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];
}
