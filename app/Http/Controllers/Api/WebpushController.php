<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebpushController extends Controller
{
    public function subscribe(Request $request)
    {
        user()->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));

        return response()->json(['success' => true]);
    }
}
