<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('discussions.index');
    }

    public function terms()
    {
        return view('static.terms');
    }

    public function charter()
    {
        return view('static.charter');
    }

    public function leaderboard()
    {
        return view('static.leaderboard');
    }
}
