<?php

namespace App\Http\Controllers\Next;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Notification as NotificationModel;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function show($board_slug = null, $thread_id = null)
    {
        $data = [];

        [$data['board'], $data['threads']] = $this->board($board_slug);

        if ($thread_id) {
            // Guess page from $thread_id
            // $thread_position = array_search($thread_id, Thread::ordered()->pluck('id')->toArray()) + 1;
            // $guessed_page = ceil($thread_position / 20);
            // request()->replace(
            //     array_merge(request()->all() + ['browse' => $guessed_page])
            // );

            $data['thread'] = fn () => $this->thread($thread_id);
        }

        return inertia('boards/show', $data);
    }

    protected function board($board_slug = null)
    {
        if ($board_slug && $board_slug != 'all') {
            $board = Board::where('slug', $board_slug)->firstOrFail();
            $threads = $board->threads();
        } else {
            $board = (new Board)->fill(['slug' => 'all', 'name' => 'Accueil']);
            $threads = Thread::query()
                ->with('board');
        }

        $threads = $threads
            ->with('latest_post')
            ->with('latest_post.user')
            ->with('user');

        $sticky_threads = collect();

        if (request()->get('browse', 1) == 1) {
            $sticky_threads = (clone $threads)
                ->sticky()
                ->get();
        }

        $threads = $threads
            ->ordered()
            ->paginate(20, ['*'], 'browse');

        if ($sticky_threads->count()) {
            $threads->setCollection(
                $sticky_threads->merge($threads)
            );
        }

        // if (user()) {
        //     $user_has_seen = DB::table('has_read_threads_users')
        //         ->select('thread_id')
        //         ->distinct('thread_id')
        //         ->where('user_id', user()->id)
        //         ->whereIn('thread_id', $threads->pluck('id'))
        //         ->pluck('thread_id');

        //     $threads->transform(function ($thread) use ($user_has_seen) {
        //         $thread->has_seen = $user_has_seen->has($thread->id);

        //         return $thread;
        //     });
        // }

        return [$board, $threads];
    }

    protected function thread($thread_id)
    {
        $thread = Thread::query()
            ->with('user')
            ->findOrFail($thread_id);

        abort_if($thread->deleted_at, 410);
        abort_if($thread->private && (auth()->guest() || $thread->members()->where('user_id', user()->id)->count() == 0), 403);

        // if (request()->page == 'last') {
        //     $post = $thread
        //         ->hasMany(Post::class)
        //         ->orderBy('created_at', 'desc')
        //         ->first();

        //     return redirect(thread::link_to_post($post));
        // }

        $posts = $thread
            ->posts()
            ->with('user')
            ->paginate(10);

        $posts->getCollection()->transform(function ($post) {
            return $post
                ->makeVisible(['created_at', 'updated_at', 'deleted_at'])
                ->append(['presented_body']);
        });

        // if (user()) {
        //     // Invalidation des notifications qui font référence à cette thread pour l'utilisateur connecté
        //     NotificationModel::query()
        //         ->where('read_at', null)
        //         ->where('notifiable_id', user()->id)
        //         ->whereIn('type', [
        //             \App\Notifications\NewPrivatethread::class,
        //             \App\Notifications\RepliesInthread::class,
        //             \App\Notifications\ReplyInthread::class,
        //         ])
        //         ->where('data->thread_id', $thread->id)
        //         ->update(['read_at' => now()]);

        //     // Invalidation des notifications qui font référence à ces posts pour l'utilisateur connecté
        //     NotificationModel::query()
        //         ->where('read_at', null)
        //         ->where('notifiable_id', user()->id)
        //         ->whereIn('type', [
        //             \App\Notifications\MentionnedInPost::class,
        //             \App\Notifications\QuotedInPost::class,
        //         ])
        //         ->whereIn('data->post_id', $posts->pluck('id'))
        //         ->update([
        //             'read_at' => now(),
        //         ]);

        //     $thread->has_read()->attach(user());
        // }

        $thread->posts = $posts;

        return $thread;
    }

    // public function index(Board $board = null, $slug = null)
    // {
    //     $boards = Board::viewables();

    //     if ($board && ! in_array($board->id, $boards->pluck('id')->toArray())) {
    //         return abort(403);
    //     }

    //     $threads = thread::query()
    //         ->whereIn('board_id', $boards->pluck('id'))
    //         ->with('board')
    //         ->with('latestPost')
    //         ->with('latestPost.user')
    //         ->with('user');

    //     if ($board) {
    //         $threads = $threads
    //             ->where('board_id', $board->id);
    //     } else {
    //         $threads = $threads
    //             ->where('board_id', '!=', Board::CATEGORY_SHITPOST);
    //     }

    //     if (request()->input('page', 1) == 1) {
    //         $sticky_threads = clone $threads;
    //         $sticky_threads = $sticky_threads->sticky()->get();
    //     } else {
    //         $sticky_threads = collect([]);
    //     }

    //     $threads = $threads->ordered()->paginate(20);

    //     if (user()) {
    //         $user_has_read = DB::table('has_read_threads_users')
    //             ->select('thread_id')
    //             ->where('user_id', user()->id)
    //             ->whereIn('thread_id', array_merge($sticky_threads->pluck('id')->toArray(), $threads->pluck('id')->toArray()))
    //             ->pluck('thread_id')
    //             ->toArray();
    //     } else {
    //         $user_has_read = [];
    //     }

    //     return inertia('thread/index', [

    //     ]);

    //     // return view('welcome', compact('boards', 'sticky_threads', 'threads', 'user_has_read'));
    // }

    // public function subscriptions()
    // {
    //     $boards = Board::viewables();

    //     $threads = thread::query()
    //         ->whereIn('board_id', $boards->pluck('id'))
    //         ->with('board')
    //         ->with('latestPost')
    //         ->with('latestPost.user')
    //         ->with('user')
    //         ->whereHas('subscribed', function ($q) {
    //             return $q->where('user_id', user()->id);
    //         });

    //     if (request()->input('page', 1) == 1) {
    //         $sticky_threads = clone $threads;
    //         $sticky_threads = $sticky_threads->sticky()->get();
    //     } else {
    //         $sticky_threads = collect([]);
    //     }

    //     $threads = $threads->ordered()->paginate(20);

    //     if (user()) {
    //         $user_has_read = DB::table('has_read_threads_users')
    //             ->select('thread_id')
    //             ->where('user_id', user()->id)
    //             ->whereIn('thread_id', array_merge($sticky_threads->pluck('id')->toArray(), $threads->pluck('id')->toArray()))
    //             ->pluck('thread_id')
    //             ->toArray();
    //     } else {
    //         $user_has_read = [];
    //     }

    //     return view('welcome', compact('boards', 'sticky_threads', 'threads', 'user_has_read'));
    // }

    // public function show($id, $slug) // Ne pas utiliser thread $thread (pour laisser possible le 410)
    // {
    //     $thread = thread::query()
    //         ->findOrFail($id);

    //     if (null !== $thread->board && ! in_array($thread->board->id, Board::viewables()->pluck('id')->toArray())) {
    //         return abort(403);
    //     }

    //     if ($thread->deleted_at && ! (user() && user()->can('read deleted threads'))) {
    //         return abort(410);
    //     }

    //     if ($thread->private && (auth()->guest() || $thread->members()->where('user_id', user()->id)->count() == 0)) {
    //         return abort(403);
    //     }

    //     // Invalidation des notifications qui font référence à cette thread pour l'utilisateur connecté
    //     if (auth()->check()) {
    //         $classes = [
    //             \App\Notifications\NewPrivatethread::class,
    //             \App\Notifications\RepliesInthread::class,
    //             \App\Notifications\ReplyInthread::class,
    //         ];

    //         NotificationModel::query()
    //             ->where('read_at', null)
    //             ->where('notifiable_id', user()->id)
    //             ->whereIn('type', $classes)
    //             ->where('data->thread_id', $thread->id)
    //             ->each(function ($notification) {
    //                 $notification->read_at = now();
    //                 $notification->save();
    //             });
    //     }

    //     if (request()->page == 'last') {
    //         $post = $thread
    //             ->hasMany(Post::class)
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         return redirect(thread::link_to_post($post));
    //     }

    //     $posts = $thread
    //         ->posts()
    //         ->with('user')
    //         ->with('thread')
    //         ->paginate(10);

    //     // Invalidation des notifications qui font référence à ces posts pour l'utilisateur connecté
    //     if (auth()->check()) {
    //         $classes = [
    //             \App\Notifications\MentionnedInPost::class,
    //             \App\Notifications\QuotedInPost::class,
    //         ];

    //         NotificationModel::query()
    //             ->where('read_at', null)
    //             ->where('notifiable_id', user()->id)
    //             ->whereIn('type', $classes)
    //             ->whereIn('data->post_id', $posts->pluck('id'))
    //             ->each(function ($notification) {
    //                 $notification->read_at = now();
    //                 $notification->save();
    //             });
    //     }

    //     $thread->has_read()->attach(user());

    //     return view('thread.show', compact('thread', 'posts'));
    // }

    // public function update(thread $thread, $slug)
    // {
    //     if (($thread->user->id != user()->id && user()->cannot('bypass threads guard')) || $thread->private) {
    //         return abort(403);
    //     }

    //     $boards = Board::postables();

    //     if (! in_array($thread->board->id, $boards->pluck('id')->toArray())) {
    //         return abort(403);
    //     }

    //     request()->validate([
    //         'title' => 'required|min:4|max:255',
    //         'board' => ['required', 'exists:boards,id', Rule::in($boards->pluck('id'))],
    //     ]);

    //     SucresHelper::throttleOrFail(__METHOD__, 3, 5);

    //     $thread->title = request()->title;

    //     // Do not update board if the post is in #shitpost
    //     if ($thread->board_id !== \App\Models\Board::CATEGORY_SHITPOST || user()->can('bypass threads guard')) {
    //         $thread->board_id = request()->board;
    //     }

    //     if (user()->can('bypass threads guard')) {
    //         $thread->sticky = request()->sticky ?? false;
    //         $thread->locked = request()->locked ?? false;

    //         activity()
    //             ->causedBy(auth()->user())
    //             ->withProperties([
    //                 'level' => 'warning',
    //                 'method' => __METHOD__,
    //                 'elevated' => true,
    //             ])
    //             ->log('threadUpdated');
    //     }

    //     $thread->save();

    //     return redirect(route('threads.show', [
    //         $thread->id,
    //         $thread->slug,
    //     ]));
    // }

    // public function subscribe(thread $thread, $slug)
    // {
    //     if ($thread->private) {
    //         return abort(403);
    //     }

    //     if (! in_array($thread->board->id, Board::viewables()->pluck('id')->toArray())) {
    //         return abort(403);
    //     }

    //     $thread->subscribed()->syncWithoutDetaching(user()->id);

    //     return redirect(route('threads.show', [
    //         $thread->id,
    //         $thread->slug,
    //     ]));
    // }

    // public function unsubscribe(thread $thread, $slug)
    // {
    //     if ($thread->private) {
    //         return abort(403);
    //     }

    //     if (! in_array($thread->board->id, Board::viewables()->pluck('id')->toArray())) {
    //         return abort(403);
    //     }

    //     $thread->subscribed()->detach(user()->id);

    //     return redirect(route('threads.show', [
    //         $thread->id,
    //         $thread->slug,
    //     ]));
    // }
}
