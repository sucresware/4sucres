<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use FollowWork\Helpers\RealtimeNotify;

class Notification extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($notification) {
            try {
                // (new RealtimeNotify())->notify($notification);
            } catch (\Exception $e) {
            }

            return $notification;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCurated($query){
        return $query->where('user_id', auth()->user()->id)->where('seen', false);
    }
}
