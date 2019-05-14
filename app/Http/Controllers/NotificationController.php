<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::curated()->get();

        return view('notifications.index', compact('notifications'));
    }

    public function clear()
    {
        Notification::curated()->update(['seen' => true]);

        return redirect()->route('notifications.index');
    }

    public function show(Notification $notification)
    {
        if ($notification->user_id != user()->id) {
            return abort(403);
        }
        $notification->seen = true;
        $notification->save();

        return redirect($notification->href);
    }
}
