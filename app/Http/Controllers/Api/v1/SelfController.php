<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class SelfController extends Controller
{
    public function me()
    {
        return request()->user();
    }

    public function lightToggler()
    {
        user()->disableLogging();

        switch (user()->getSetting('layout.theme', 'light-theme')) {
            case 'light-theme':
                user()->setSetting('layout.theme', 'dark-theme');

            break;
            case 'dark-theme':
                user()->setSetting('layout.theme', 'light-theme');

            break;
        }

        return ['success' => true];
    }

    public function notifications()
    {
        return Notification::query()
            ->where('notifiable_id', user()->id)
            ->where('read_at', null)
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get()
            ->transform(function ($notification) {
                $notification->presented_created_at = $notification->created_at->diffForHumans();

                return $notification;
            });
    }
}
