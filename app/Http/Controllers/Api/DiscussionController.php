<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discussion;

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
