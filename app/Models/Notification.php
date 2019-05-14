<?php

namespace App\Models;

use App\Events\NotificationCreated;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($notification) {
            event(new NotificationCreated($notification));

            return $notification;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCurated($query)
    {
        return $query->where('user_id', user()->id)->where('seen', false);
    }
}
