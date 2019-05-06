<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function create()
    {
        $categories = Category::ordered()->filtered()->pluck('name', 'id');

        return view('discussion.create', compact('categories'));
    }

    public function store()
    {
        request()->validate([
            'title' => 'required|min:10',
            'body' => 'required|min:10',
            'category' => 'required|exists:categories,id',
        ]);

        $discussion = Discussion::create([
            'title' => request()->title,
            'user_id' => auth()->user()->id,
            'category_id' => request()->category,
        ]);

        $post = $discussion->posts()->create([
            'body' => request()->body,
            'user_id' => auth()->user()->id,
        ]);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug
        ]));
    }

    public function index(Category $category = null, $slug = null)
    {
        $categories = Category::ordered()->get();

        $discussions = Discussion::query();

        if ($category) {
            $discussions = $discussions->where('category_id', $category->id);
        }

        if (request()->input('page', 1) == 1) {
            $sticky_discussions = clone $discussions;
            $sticky_discussions = $sticky_discussions->sticky()->get();
        } else {
            $sticky_discussions = collect([]);
        }

        $discussions = $discussions->ordered()->paginate(20);

        return view('welcome', compact('categories', 'sticky_discussions', 'discussions'));
    }

    public function show(Discussion $discussion, $slug)
    {
        $posts = $discussion->posts()->paginate(10);

        return view('discussion.show', compact('discussion', 'posts'));
    }

    public function update(Discussion $discussion, $slug){
        request()->validate([
            'title' => 'required|min:10',
            'category' => 'required|exists:categories,id',
        ]);

        $discussion->title = request()->title;
        $discussion->category_id = request()->category;
        $discussion->sticky = request()->sticky ?? false;
        $discussion->save();

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug
        ]));
    }
}
