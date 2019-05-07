<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(){
        $notifications = Notification::curated()->get();

        return view('notifications.index', compact('notifications'));
    }

    public function all_read(){
        Notification::curated()->update(['seen' => true]);

        return redirect('notifications.index');
    }

    public function show(Notification $notification){
        if ($notification->user_id != auth()->user()->id) {
            return abort(403);
        }
        $notification->seen = true;
        $notification->save();

        return redirect($notification->href);
    }
}
