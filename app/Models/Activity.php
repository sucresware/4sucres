<?php

namespace App\Models;

use App\Events\ActivityLogged;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    public static function boot()
    {
        parent::boot();

        self::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->merge([
                'ip'     => request()->ip(),
                'ua'     => request()->userAgent(),
            ]);

            return $activity;
        });

        self::created(function ($activity) {
            broadcast(new ActivityLogged($activity));

            return true;
        });
    }
}
