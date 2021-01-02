<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Models\Board;
use App\Models\thread;
use App\Models\Post;
use Illuminate\Http\Request;

class threadPostController extends Controller
{
    public function edit(thread $thread, $slug, Post $post)
    {
        if ((($post->user->id != user()->id || $post->deleted) && user()->cannot('bypass threads guard')) || $thread->private) {
            return abort(403);
        }

        if (! in_array($thread->board->id, Board::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        $more_options = ($thread->posts()->first() == $post);
        $boards = Board::replyable()->pluck('name', 'id');

        return view('thread.post.edit', compact('boards', 'thread', 'post', 'more_options'));
    }

    public function update(thread $thread, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass threads guard')) || $thread->private) {
            activity()
                ->performedOn($thread)
                ->causedBy(user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        if (! in_array($thread->board->id, Board::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        request()->validate([
            'body' => 'required|min:3',
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 5, 3);

        $post->body = request()->input('body');
        $post->save();

        return redirect($post->link);
    }

    public function delete(thread $thread, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass threads guard')) || $thread->private) {
            return abort(403);
        }

        if (! in_array($thread->board->id, Board::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        return view('thread.post.delete', compact('thread', 'post'));
    }

    public function destroy(thread $thread, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass threads guard')) || $thread->private) {
            activity()
                ->performedOn($thread)
                ->causedBy(user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        if (! in_array($thread->board->id, Board::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        if ($post->id == $thread->posts[0]->id) {
            SucresHelper::throttleOrFail(__METHOD__ . '_D', 1, 5);

            $now = now();

            $thread->posts()->update([
                'deleted_at' => $now,
            ]);

            $thread->deleted_at = $now;
            $thread->save();

            activity()
                ->performedOn($thread)
                ->causedBy(user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('threadSoftDeleted');

            return redirect(route('home'));
        } else {
            SucresHelper::throttleOrFail(__METHOD__, 5, 3);

            $post->deleted_at = now();
            $post->save();

            activity()
                ->performedOn($post)
                ->causedBy(user())
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PostSoftDeleted');

            return redirect(route('threads.show', [
                $thread->id,
                $thread->slug,
            ]));
        }
    }

    public function react(thread $thread, $slug, Post $post)
    {
        // request()->validate([
        //     'reaction' => 'required', 'in:angry,happy,love,sad,sick,sueur,what,oh'
        // ]);

        // $post->toggleReaction(request()->reaction);

        // return response()->json([
        //     'reaction_summary' => $post->reaction_summary,
        // ]);
    }
}
