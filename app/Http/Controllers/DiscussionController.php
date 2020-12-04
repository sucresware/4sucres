<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Helpers\SucresHelper;
use App\Helpers\SucresParser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Notification as NotificationModel;

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

        $categories = Category::postables()->pluck('name', 'id');

        return view('discussion.create', compact('categories'));
    }

    public function preview()
    {
        if (user()->cannot('create discussions')) {
            return abort(403);
        }

        request()->validate([
            'body' => 'required|min:3|max:10000',
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 15, 1);

        $post = new Post();
        $post->user = user();
        $post->body = request()->body;

        return response([
            'render' => (new SucresParser($post))->render(),
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

        $categories = Category::postables()->pluck('id');

        request()->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'body' => ['required', 'min:3', 'max:10000'],
            'category' => ['required', 'exists:categories,id', Rule::in($categories)],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 5, 10);

        $discussion = Discussion::create([
            'title' => request()->title,
            'user_id' => user()->id,
            'category_id' => request()->category,
        ]);

        $post = $discussion->posts()->create([
            'body' => request()->body,
            'user_id' => user()->id,
        ]);

        if (user()->getSetting('notifications.subscribe_on_create', true)) {
            $discussion->subscribed()->syncWithoutDetaching(user()->id);
        }

        return redirect($post->link);
    }

    public function index(Category $category = null, $slug = null)
    {
        $categories = Category::viewables();

        if ($category && ! in_array($category->id, $categories->pluck('id')->toArray())) {
            return abort(403);
        }

        $discussions = Discussion::query()
            ->whereIn('category_id', $categories->pluck('id'))
            ->with('category')
            ->with('latestPost')
            ->with('latestPost.user')
            ->with('user');

        if ($category) {
            $discussions = $discussions
                ->where('category_id', $category->id);
        } else {
            $discussions = $discussions
                ->where('category_id', '!=', Category::CATEGORY_SHITPOST);
        }

        if (request()->input('page', 1) == 1) {
            $sticky_discussions = clone $discussions;
            $sticky_discussions = $sticky_discussions->sticky()->get();
        } else {
            $sticky_discussions = collect([]);
        }

        $discussions = $discussions->ordered()->paginate(20);

        if (user()) {
            $user_has_read = DB::table('has_read_discussions_users')
                ->select('discussion_id')
                ->where('user_id', user()->id)
                ->whereIn('discussion_id', array_merge($sticky_discussions->pluck('id')->toArray(), $discussions->pluck('id')->toArray()))
                ->pluck('discussion_id')
                ->toArray();
        } else {
            $user_has_read = [];
        }

        return view('welcome', compact('categories', 'sticky_discussions', 'discussions', 'user_has_read'));
    }

    public function subscriptions()
    {
        $categories = Category::viewables();

        $discussions = Discussion::query()
            ->whereIn('category_id', $categories->pluck('id'))
            ->with('category')
            ->with('latestPost')
            ->with('latestPost.user')
            ->with('user')
            ->whereHas('subscribed', function ($q) {
                return $q->where('user_id', user()->id);
            });

        if (request()->input('page', 1) == 1) {
            $sticky_discussions = clone $discussions;
            $sticky_discussions = $sticky_discussions->sticky()->get();
        } else {
            $sticky_discussions = collect([]);
        }

        $discussions = $discussions->ordered()->paginate(20);

        if (user()) {
            $user_has_read = DB::table('has_read_discussions_users')
                ->select('discussion_id')
                ->where('user_id', user()->id)
                ->whereIn('discussion_id', array_merge($sticky_discussions->pluck('id')->toArray(), $discussions->pluck('id')->toArray()))
                ->pluck('discussion_id')
                ->toArray();
        } else {
            $user_has_read = [];
        }

        return view('welcome', compact('categories', 'sticky_discussions', 'discussions', 'user_has_read'));
    }

    public function show($id, $slug) // Ne pas utiliser Discussion $discussion (pour laisser possible le 410)
    {
        $discussion = Discussion::query()
            ->findOrFail($id);

        if (null !== $discussion->category && ! in_array($discussion->category->id, Category::viewables()->pluck('id')->toArray())) {
            return abort(403);
        }

        if ($discussion->deleted_at && ! (user() && user()->can('read deleted discussions'))) {
            return abort(410);
        }

        if ($discussion->private && (auth()->guest() || $discussion->members()->where('user_id', user()->id)->count() == 0)) {
            return abort(403);
        }

        // Invalidation des notifications qui font référence à cette discussion pour l'utilisateur connecté
        if (auth()->check()) {
            $classes = [
                \App\Notifications\NewPrivateDiscussion::class,
                \App\Notifications\RepliesInDiscussion::class,
                \App\Notifications\ReplyInDiscussion::class,
            ];

            NotificationModel::query()
                ->where('read_at', null)
                ->where('notifiable_id', user()->id)
                ->whereIn('type', $classes)
                ->where('data->discussion_id', $discussion->id)
                ->each(function ($notification) {
                    $notification->read_at = now();
                    $notification->save();
                });
        }

        if (request()->page == 'last') {
            $post = $discussion
                ->hasMany(Post::class)
                ->orderBy('created_at', 'desc')
                ->first();

            return redirect(Discussion::link_to_post($post));
        }

        $posts = $discussion
            ->posts()
            ->with('user')
            ->with('discussion')
            ->paginate(10);

        // Invalidation des notifications qui font référence à ces posts pour l'utilisateur connecté
        if (auth()->check()) {
            $classes = [
                \App\Notifications\MentionnedInPost::class,
                \App\Notifications\QuotedInPost::class,
            ];

            NotificationModel::query()
                ->where('read_at', null)
                ->where('notifiable_id', user()->id)
                ->whereIn('type', $classes)
                ->whereIn('data->post_id', $posts->pluck('id'))
                ->each(function ($notification) {
                    $notification->read_at = now();
                    $notification->save();
                });
        }

        $discussion->has_read()->attach(user());

        return view('discussion.show', compact('discussion', 'posts'));
    }

    public function update(Discussion $discussion, $slug)
    {
        if (($discussion->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        $categories = Category::postables();

        if (! in_array($discussion->category->id, $categories->pluck('id')->toArray())) {
            return abort(403);
        }

        request()->validate([
            'title' => 'required|min:4|max:255',
            'category' => ['required', 'exists:categories,id', Rule::in($categories->pluck('id'))],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 3, 5);

        $discussion->title = request()->title;

        // Do not update category if the post is in #shitpost
        if ($discussion->category_id !== \App\Models\Category::CATEGORY_SHITPOST || user()->can('bypass discussions guard')) {
            $discussion->category_id = request()->category;
        }

        if (user()->can('bypass discussions guard')) {
            $discussion->sticky = request()->sticky ?? false;
            $discussion->locked = request()->locked ?? false;

            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                    'elevated' => true,
                ])
                ->log('DiscussionUpdated');
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

        if (! in_array($discussion->category->id, Category::viewables()->pluck('id')->toArray())) {
            return abort(403);
        }

        $discussion->subscribed()->syncWithoutDetaching(user()->id);

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

        if (! in_array($discussion->category->id, Category::viewables()->pluck('id')->toArray())) {
            return abort(403);
        }

        $discussion->subscribed()->detach(user()->id);

        return redirect(route('discussions.show', [
            $discussion->id,
            $discussion->slug,
        ]));
    }
}
