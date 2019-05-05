<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;

class HomeController extends Controller
{
    public function index()
    {
        if (request()->input('page', 1) == 1) {
            $sticky_discussions = Discussion::sticky()->get();
        } else {
            $sticky_discussions = collect([]);
        }

        $discussions = Discussion::ordered()->paginate(20);
        return view('welcome', compact('sticky_discussions', 'discussions'));
    }
}
