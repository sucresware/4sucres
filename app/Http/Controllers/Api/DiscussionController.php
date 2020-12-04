<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Discussion;
use App\Http\Controllers\Controller;

class DiscussionController extends Controller
{
    public function show(Discussion $discussion)
    {
        $categories = Category::viewables();

        if ($discussion->category && ! in_array($discussion->category->id, $categories->pluck('id')->toArray())) {
            return abort(403);
        }

        $posts = $discussion->posts()
            ->with('user')
            ->with('discussion')
            ->paginate(10);

        return response()->json($posts);
    }
}
