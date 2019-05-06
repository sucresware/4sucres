<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Notifications\Notification;

class HomeController extends Controller
{
    public function index(){
        return redirect()->route('discussions.index');
    }

    public function terms(){
        return view('static.terms');
    }

    public function charter(){
        return view('static.charter');
    }

    public function leaderboard(){
        return view('static.leaderboard');
    }
}
