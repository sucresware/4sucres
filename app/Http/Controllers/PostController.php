<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Post;

class PostController extends Controller
{
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);

        return redirect(Thread::link_to_post($post));
    }
}
