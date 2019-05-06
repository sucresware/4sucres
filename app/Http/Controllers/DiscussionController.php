<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function create()
    {
        return view('discussion.create');
    }

    public function store()
    {
        request()->validate([
            'title' => 'required|min:10',
            'body' => 'required|min:10',
        ]);

        $discussion = Discussion::create([
            'title' => request()->input('title'),
            'user_id' => auth()->user()->id,
        ]);

        $post = $discussion->posts()->create([
            'body' => request()->input('body'),
            'user_id' => auth()->user()->id,
        ]);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug
        ]));
    }

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

    public function show(Discussion $discussion, $slug)
    {
        $posts = $discussion->posts()->paginate(10);

        return view('discussion.show', compact('discussion', 'posts'));
    }
}
