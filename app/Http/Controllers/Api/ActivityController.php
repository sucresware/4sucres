<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function ping()
    {
        return response()->json([
            'success' => true
        ]);
    }
}
