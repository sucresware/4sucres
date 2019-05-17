<?php

namespace App\Http\Controllers\Api;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscussionController extends Controller
{
    public function show(Discussion $discussion)
    {
        $posts = $discussion->posts()
            ->with('user')
            ->with('discussion')
            ->paginate(10);

        $posts->map(function ($post) {
            $post->presented_body = $post->presented_body;
            $post->link = $post->link;
            $post->user->link = $post->user->link;
            $post->user->avatar = $post->user->avatar;
            $post->presented_created_at = $post->created_at->format('d/m/Y à H:i:s');
            $post->presented_updated_at = $post->updated_at->format('d/m/Y à H:i:s');

            return $post;
        });

        return response()->json($posts);
    }
}
