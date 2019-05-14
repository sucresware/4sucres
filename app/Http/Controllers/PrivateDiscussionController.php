<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Notifications\NewPrivateDiscussion;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class PrivateDiscussionController extends Controller
{
    public function index()
    {
        $private_discussions = Discussion::private(user())->get();

        return view('discussion.private.index', compact('private_discussions'));
    }

    public function create(User $user)
    {
        $from = user();
        $to = $user;

        return view('discussion.private.create', compact('from', 'to'));
    }

    public function store(User $user)
    {
        $from = user();
        $to = $user;

        request()->validate([
            'title' => 'required|min:10',
            'body' => 'required|min:10',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('create_private_discussion_action')],
        ]);

        $discussion = Discussion::create([
            'title' => request()->title,
            'user_id' => user()->id,
            'category_id' => 0,
            'private' => true,
        ]);

        $post = $discussion->posts()->create([
            'body' => request()->body,
            'user_id' => user()->id,
        ]);

        $discussion->members()->attach([$from->id, $to->id]);
        $discussion->subscribed()->attach([$from->id, $to->id]);

        $to->notify(new NewPrivateDiscussion($discussion));

        return redirect($post->link);
    }
}
