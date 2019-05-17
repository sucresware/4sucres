<?php

namespace App\Http\Controllers\Api;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionController extends Controller
{
    public function show(Discussion $discussion)
    {
        $posts = $discussion->posts()
            ->with('user')
            ->with('discussion')
            ->paginate(10);

        return response()->json($posts);
    }
}
