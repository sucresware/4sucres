<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Discussion;
use Illuminate\Http\Request;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class DiscussionController extends Controller
{
    public function create()
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        if (user()->cannot('create discussions')) {
            return abort(403);
        }

        $categories = Category::ordered()->filtered()->pluck('name', 'id');

        return view('discussion.create', compact('categories'));
    }

    public function preview()
    {
        if (user()->cannot('create discussions')) {
            return abort(403);
        }

        request()->validate([
            'body' => 'required|min:3|max:3000',
        ]);

        $post = new Post();
        $post->body = request()->body;

        return response([
            'render' => $post->presented_body,
        ]);
    }

    public function store()
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        if (user()->cannot('create discussions')) {
            return abort(403);
        }

        request()->validate([
            'title' => 'required|min:4|max:255',
            'body' => 'required|min:3|max:3000',
            'category' => 'required|exists:categories,id',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('create_discussion_action')],
        ]);

        $discussion = Discussion::create([
            'title' => request()->title,
            'user_id' => user()->id,
            'category_id' => request()->category,
        ]);

        $post = $discussion->posts()->create([
            'body' => request()->body,
            'user_id' => user()->id,
        ]);

        $discussion->subscribed()->attach(user()->id);

        return redirect($post->link);
    }

    public function index(Category $category = null, $slug = null)
    {
        $categories = Category::ordered()->get();
        $discussions = Discussion::query()
            ->with('category')
            ->with('posts')
            ->with('posts.user')
            ->with('user');

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

    public function subscriptions()
    {
        $categories = Category::ordered()->get();

        $discussions = Discussion::query();
        $discussions = $discussions->whereHas('subscribed', function ($q) {
            return $q->where('user_id', user()->id);
        });

        if (request()->input('page', 1) == 1) {
            $sticky_discussions = clone $discussions;
            $sticky_discussions = $sticky_discussions->sticky()->get();
        } else {
            $sticky_discussions = collect([]);
        }

        $discussions = $discussions->ordered()->paginate(20);

        return view('welcome', compact('categories', 'sticky_discussions', 'discussions'));
    }

    public function show($id, $slug) // Ne pas utiliser Discussion $discussion (pour laisser possible le 410)
    {
        $discussion = Discussion::query()
            ->withTrashed()
            ->with('posts')
            ->with('posts.user')
            ->findOrFail($id);

        if ($discussion->trashed()) {
            return abort(410);
        }

        if ($discussion->private && (auth()->guest() || $discussion->members()->where('user_id', user()->id)->count() == 0)) {
            return abort(403);
        }

        $posts = $discussion->posts()->paginate(10);

        $discussion->has_read()->attach(user());

        return view('discussion.show', compact('discussion', 'posts'));
    }

    public function update(Discussion $discussion, $slug)
    {
        if (($discussion->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        request()->validate([
            'title' => 'required|min:4|max:255',
            'category' => 'required|exists:categories,id',
        ]);

        $discussion->title = request()->title;
        $discussion->category_id = request()->category;

        if (user()->can('bypass discussions guard')) {
            $discussion->sticky = request()->sticky ?? false;
            $discussion->locked = request()->locked ?? false;
        }

        $discussion->save();

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }

    public function subscribe(Discussion $discussion, $slug)
    {
        if ($discussion->private) {
            return abort(403);
        }

        $discussion->subscribed()->attach(user()->id);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }

    public function unsubscribe(Discussion $discussion, $slug)
    {
        if ($discussion->private) {
            return abort(403);
        }

        $discussion->subscribed()->detach(user()->id);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }
}
