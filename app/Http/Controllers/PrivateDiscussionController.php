<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\User;
use App\Notifications\NewPrivateDiscussion;
use Illuminate\Http\Request;

class PrivateDiscussionController extends Controller
{
    public function index()
    {
        $private_discussions = Discussion::private(user())->get();

        return view('discussion.private.index', compact('private_discussions'));
    }

    public function create(User $user)
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        $from = user();
        $to = $user;

        return view('discussion.private.create', compact('from', 'to'));
    }

    public function store(User $user)
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        $from = user();
        $to = $user;

        request()->validate([
            'title' => 'required|min:3',
            'body'  => 'required|min:3',
        ]);

        $discussion = Discussion::create([
            'title'       => request()->title,
            'user_id'     => user()->id,
            'category_id' => 0,
            'private'     => true,
        ]);

        $post = $discussion->posts()->create([
            'body'    => request()->body,
            'user_id' => user()->id,
        ]);

        $discussion->members()->attach([$from->id, $to->id]);
        $discussion->subscribed()->attach([$from->id, $to->id]);

        $to->notify(new NewPrivateDiscussion($discussion));

        return redirect($post->link);
    }
}
