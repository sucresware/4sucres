<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;

class HomeController extends Controller
{
    function index(){
        return redirect()->route('discussions.index');
    }
}
