<?php

namespace App\Http\Controllers\Next;

use App\Http\Controllers\Controller;
use App\Models\Notification as NotificationModel;
use App\Models\Thread;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    // public function create()
    // {
    //     if (user()->restricted) {
    //         return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
    //     }

    //     if (user()->cannot('create threads')) {
    //         return abort(403);
    //     }

    //     $boards = Board::replyables()->pluck('name', 'id');

    //     return view('thread.create', compact('boards'));
    // }

    // public function preview()
    // {
    //     if (user()->cannot('create threads')) {
    //         return abort(403);
    //     }

    //     request()->validate([
    //         'body' => 'required|min:3|max:10000',
    //     ]);

    //     SucresHelper::throttleOrFail(__METHOD__, 15, 1);

    //     $reply = new Reply();
    //     $reply->user = user();
    //     $reply->body = request()->body;

    //     return response([
    //         'render' => (new SucresParser($reply))->render(),
    //     ]);
    // }

    // public function store()
    // {
    //     if (user()->restricted) {
    //         return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
    //     }

    //     if (user()->cannot('create threads')) {
    //         return abort(403);
    //     }

    //     $boards = Board::replyables()->pluck('id');

    //     request()->validate([
    //         'title' => ['required', 'min:3', 'max:255'],
    //         'body' => ['required', 'min:3', 'max:10000'],
    //         'board' => ['required', 'exists:boards,id', Rule::in($boards)],
    //     ]);

    //     SucresHelper::throttleOrFail(__METHOD__, 5, 10);

    //     $thread = thread::create([
    //         'title' => request()->title,
    //         'user_id' => user()->id,
    //         'board_id' => request()->board,
    //     ]);

    //     $reply = $thread->replies()->create([
    //         'body' => request()->body,
    //         'user_id' => user()->id,
    //     ]);

    //     if (user()->getSetting('notifications.subscribe_on_create', true)) {
    //         $thread->subscribed()->syncWithoutDetaching(user()->id);
    //     }

    //     return redirect($reply->link);
    // }

    public function index($threadId = null)
    {
        $data = [];

        if ($threadId) {
            // Guess page from $threadId
            $threadPosition = array_search($threadId, thread::ordered()->pluck('id')->toArray()) + 1;
            $guessedPage = ceil($threadPosition / 20);
            request()->replace(
                array_merge(request()->all() + ['browse' => $guessedPage])
            );

            $data['thread'] = function () use ($threadId) {
                return $this->thread($threadId);
            };
        }

        $data['threads'] = function () {
            return $this->threads();
        };

        return inertia('thread/index', $data);
    }

    protected function threads()
    {
        $sticky_threads = collect();

        $threads = thread::query()
            ->with('latestReply')
            ->with('latestReply.user')
            ->with('user');

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

        if (user()) {
            $user_has_seen = DB::table('has_read_threads_users')
                ->select('thread_id')
                ->distinct('thread_id')
                ->where('user_id', user()->id)
                ->whereIn('thread_id', $threads->pluck('id'))
                ->pluck('thread_id');

            $threads->transform(function ($thread) use ($user_has_seen) {
                $thread->has_seen = $user_has_seen->has($thread->id);

                return $thread;
            });
        }

        return $threads;
    }

    protected function thread($threadId)
    {
        $thread = thread::query()
            ->with('user')
            ->findOrFail($threadId);

        abort_if($thread->deleted_at, 410);
        abort_if($thread->private && (auth()->guest() || $thread->members()->where('user_id', user()->id)->count() == 0), 403);

        // if (request()->page == 'last') {
        //     $reply = $thread
        //         ->hasMany(Reply::class)
        //         ->orderBy('created_at', 'desc')
        //         ->first();

        //     return redirect(thread::link_to_reply($reply));
        // }

        $replies = $thread
            ->replies()
            ->with('user')
            ->paginate(10);

        $replies->getCollection()->transform(function ($reply) {
            return $reply
                ->makeVisible(['created_at', 'updated_at', 'deleted_at'])
                ->append(['presented_body']);
        });

        if (user()) {
            // Invalidation des notifications qui font référence à cette thread pour l'utilisateur connecté
            NotificationModel::query()
                ->where('read_at', null)
                ->where('notifiable_id', user()->id)
                ->whereIn('type', [
                    \App\Notifications\NewPrivatethread::class,
                    \App\Notifications\RepliesInthread::class,
                    \App\Notifications\ReplyInthread::class,
                ])
                ->where('data->thread_id', $thread->id)
                ->update(['read_at' => now()]);

            // Invalidation des notifications qui font référence à ces replies pour l'utilisateur connecté
            NotificationModel::query()
                ->where('read_at', null)
                ->where('notifiable_id', user()->id)
                ->whereIn('type', [
                    \App\Notifications\MentionnedInReply::class,
                    \App\Notifications\QuotedInReply::class,
                ])
                ->whereIn('data->reply_id', $replies->pluck('id'))
                ->update([
                    'read_at' => now(),
                ]);

            $thread->has_read()->attach(user());
        }

        $thread->replies = $replies;

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
    //         ->with('latestReply')
    //         ->with('latestReply.user')
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
    //         ->with('latestReply')
    //         ->with('latestReply.user')
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
    //         $reply = $thread
    //             ->hasMany(Reply::class)
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         return redirect(thread::link_to_reply($reply));
    //     }

    //     $replies = $thread
    //         ->replies()
    //         ->with('user')
    //         ->with('thread')
    //         ->paginate(10);

    //     // Invalidation des notifications qui font référence à ces replies pour l'utilisateur connecté
    //     if (auth()->check()) {
    //         $classes = [
    //             \App\Notifications\MentionnedInReply::class,
    //             \App\Notifications\QuotedInReply::class,
    //         ];

    //         NotificationModel::query()
    //             ->where('read_at', null)
    //             ->where('notifiable_id', user()->id)
    //             ->whereIn('type', $classes)
    //             ->whereIn('data->reply_id', $replies->pluck('id'))
    //             ->each(function ($notification) {
    //                 $notification->read_at = now();
    //                 $notification->save();
    //             });
    //     }

    //     $thread->has_read()->attach(user());

    //     return view('thread.show', compact('thread', 'replies'));
    // }

    // public function update(thread $thread, $slug)
    // {
    //     if (($thread->user->id != user()->id && user()->cannot('bypass threads guard')) || $thread->private) {
    //         return abort(403);
    //     }

    //     $boards = Board::replyables();

    //     if (! in_array($thread->board->id, $boards->pluck('id')->toArray())) {
    //         return abort(403);
    //     }

    //     request()->validate([
    //         'title' => 'required|min:4|max:255',
    //         'board' => ['required', 'exists:boards,id', Rule::in($boards->pluck('id'))],
    //     ]);

    //     SucresHelper::throttleOrFail(__METHOD__, 3, 5);

    //     $thread->title = request()->title;

    //     // Do not update board if the reply is in #shitreply
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
