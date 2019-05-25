<?php

namespace App\Models;

use App\Events\ActivityLogged;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    public static function boot()
    {
        parent::boot();

        self::created(function ($created_activity) {
            broadcast(new ActivityLogged($created_activity));

            return true;
        });
    }
}
