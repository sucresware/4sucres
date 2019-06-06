<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Models\Category;
use App\Models\Discussion;
use App\Models\Post;
use Illuminate\Http\Request;

class DiscussionPostController extends Controller
{
    public function store(Discussion $discussion, $slug)
    {
        if (user()->restricted && user()->restricted_posts_remaining <= 0) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant de continuer à répondre !');
        }

        if (null !== $discussion->category && !in_array($discussion->category->id, Category::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        if ($discussion->locked || user()->cannot('create discussions')) {
            activity()
                ->performedOn($discussion)
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        request()->validate([
            'body' => ['required', 'min:3', 'max:10000'],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 7, 1);

        $post = $discussion->posts()->create([
            'body'    => request()->input('body'),
            'user_id' => user()->id,
        ]);

        if (user()->getSetting('notifications.subscribe_on_reply', false)) {
            $discussion->subscribed()->syncWithoutDetaching(user()->id);
        }

        return redirect($post->link);
    }

    public function edit(Discussion $discussion, $slug, Post $post)
    {
        if ((($post->user->id != user()->id || $post->deleted) && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        if (!in_array($discussion->category->id, Category::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        $more_options = ($discussion->posts()->first() == $post);
        $categories = Category::replyable()->pluck('name', 'id');

        return view('discussion.post.edit', compact('categories', 'discussion', 'post', 'more_options'));
    }

    public function update(Discussion $discussion, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            activity()
                ->performedOn($discussion)
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        if (!in_array($discussion->category->id, Category::replyable()->pluck('id')->toArray())) {
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

    public function delete(Discussion $discussion, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        if (!in_array($discussion->category->id, Category::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        return view('discussion.post.delete', compact('discussion', 'post'));
    }

    public function destroy(Discussion $discussion, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            activity()
                ->performedOn($discussion)
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        if (!in_array($discussion->category->id, Category::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        if ($post->id == $discussion->posts[0]->id) {
            SucresHelper::throttleOrFail(__METHOD__ . '_D', 1, 5);

            $discussion->posts()->update([
                'deleted_at' => now(),
            ]);

            $discussion->deleted_at = now();
            $discussion->save();

            activity()
                ->performedOn($discussion)
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('DiscussionSoftDeleted');

            return redirect(route('home'));
        } else {
            SucresHelper::throttleOrFail(__METHOD__, 5, 3);

            $post->deleted_at = now();
            $post->save();

            activity()
                ->performedOn($post)
                ->causedBy(user())
                ->withProperties([
                    'level'  => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PostSoftDeleted');

            return redirect(route('discussions.show', [
                $discussion->id,
                $discussion->slug,
            ]));
        }
    }

    public function react(Discussion $discussion, $slug, Post $post)
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
