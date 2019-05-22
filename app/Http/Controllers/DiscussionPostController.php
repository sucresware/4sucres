<?php

namespace App\Http\Controllers;

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

        if ($discussion->locked || user()->cannot('create discussions')) {
            return abort(403);
        }

        request()->validate([
            'body' => 'required|min:3|max:3000',
        ]);

        $post = $discussion->posts()->create([
            'body'    => request()->input('body'),
            'user_id' => user()->id,
        ]);

        activity()
            ->performedOn($post)
            ->withProperties(['level' => 'info'])
            ->log('Nouveau post');

        return redirect($post->link);
    }

    public function edit(Discussion $discussion, $slug, Post $post)
    {
        if ((($post->user->id != user()->id || $post->deleted) && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        $more_options = ($discussion->posts()->first() == $post);
        $categories = Category::ordered()->filtered()->pluck('name', 'id');

        return view('discussion.post.edit', compact('categories', 'discussion', 'post', 'more_options'));
    }

    public function update(Discussion $discussion, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            return abort(403);
        }

        request()->validate([
            'body' => 'required|min:3',
        ]);

        $post->body = request()->input('body');
        $post->save();

        return redirect($post->link);
    }

    public function delete(Discussion $discussion, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            activity()
                ->performedOn($discussion)
                ->withProperties(['level' => 'warning'])
                ->log('Tentative de suppression de post/discussion refusée (GET)');

            return abort(403);
        }

        return view('discussion.post.delete', compact('discussion', 'post'));
    }

    public function destroy(Discussion $discussion, $slug, Post $post)
    {
        if (($post->user->id != user()->id && user()->cannot('bypass discussions guard')) || $discussion->private) {
            activity()
                ->performedOn($discussion)
                ->withProperties(['level' => 'warning'])
                ->log('Tentative de suppression de post/discussion refusée (DELETE)');

            return abort(403);
        }

        if ($post->id == $discussion->posts[0]->id) {
            $discussion->posts()->update([
                'deleted_at' => now(),
            ]);

            $discussion->deleted_at = now();
            $discussion->save();

            activity()
                ->performedOn($discussion)
                ->withProperties(['level' => 'notice'])
                ->log('Discussion supprimée');

            return redirect(route('home'));
        } else {
            $post->deleted_at = now();
            $post->save();

            activity()
                ->performedOn($post)
                ->withProperties(['level' => 'notice'])
                ->log('Post supprimé');

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
