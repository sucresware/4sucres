<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function show($id, $slug)
    {
        $discussion = Discussion::findOrFail($id);
        $posts = $discussion->posts()->paginate(10);

        return view('discussion.show', compact('discussion', 'posts'));
    }
}
