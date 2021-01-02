<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\thread;

class threadController extends Controller
{
    public function show(thread $thread)
    {
        $boards = Board::viewables();

        if ($thread->board && ! in_array($thread->board->id, $boards->pluck('id')->toArray())) {
            return abort(403);
        }

        $posts = $thread->posts()
            ->with('user')
            ->with('thread')
            ->paginate(10);

        return response()->json($posts);
    }
}
