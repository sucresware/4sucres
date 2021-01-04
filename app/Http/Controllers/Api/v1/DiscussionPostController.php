<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\SucresHelper;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Thread;

class threadPostController extends Controller
{
    public function store(thread $thread)
    {
        if (user('api')->restricted && user('api')->restricted_posts_remaining <= 0) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant de continuer à répondre !');
        }

        if (null !== $thread->board && ! in_array($thread->board->id, Board::replyable()->pluck('id')->toArray())) {
            return abort(403);
        }

        if ($thread->locked || user('api')->cannot('create threads')) {
            activity()
                ->performedOn($thread)
                ->causedBy(user('api'))
                ->withProperties([
                    'level' => 'warning',
                    'method' => __METHOD__,
                ])
                ->log('PermissionWarn');

            return abort(403);
        }

        request()->validate([
            'body' => ['required', 'min:3', 'max:10000'],
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 7, 1);

        $latest_post = $thread->latestPost()->notTrashed()->first();

        if ($latest_post->user_id == user('api')->id && $latest_post->created_at->between(now()->subMinutes(2), now())) {
            $latest_post->body .= "\r\n\r\n" . '[b]AutoEdit[/b] : ' . request()->input('body');
            $latest_post->save();

            $post = $latest_post;
        } else {
            $post = $thread->posts()->create([
                'body' => request()->input('body'),
                'user_id' => user('api')->id,
            ]);

            if (user('api')->getSetting('notifications.subscribe_on_reply', false)) {
                $thread->subscribed()->syncWithoutDetaching(user('api')->id);
            }
        }

        return ['redirect' => $post->link];
    }
}
