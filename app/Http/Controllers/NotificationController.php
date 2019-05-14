<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = user()->unreadNotifications;

        return view('notifications.index', compact('notifications'));
    }

    public function clear()
    {
        user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->route('notifications.index');
    }

    public function show($notification_id)
    {
        $notification = user()->notifications()->where('id', $notification_id)->first();
        $notification->markAsRead();

        return redirect($notification->data['target']);
    }
}
