<?php

namespace App\Http\Controllers\Next;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return inertia('home');
        // return redirect()->route('next.discussions.index');
    }
}
