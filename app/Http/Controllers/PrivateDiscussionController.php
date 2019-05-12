<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class PrivateDiscussionController extends Controller
{
    public function index()
    {
        $private_discussions = Discussion::private(auth()->user())->get();

        return view('discussion.private.index', compact('private_discussions'));
    }

    public function create(User $user)
    {
        $from = auth()->user();
        $to = $user;

        return view('discussion.private.create', compact('from', 'to'));
    }

    public function store(User $user)
    {
        $from = auth()->user();
        $to = $user;

        request()->validate([
            'title' => 'required|min:10',
            'body' => 'required|min:10',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('create_private_discussion_action')],
        ]);

        $discussion = Discussion::create([
            'title' => request()->title,
            'user_id' => auth()->user()->id,
            'category_id' => 0,
            'private' => true,
        ]);

        $post = $discussion->posts()->create([
            'body' => request()->body,
            'user_id' => auth()->user()->id,
        ]);

        $discussion->members()->attach([$from->id, $to->id]);
        $discussion->subscribed()->attach([$from->id, $to->id]);

        return redirect(Discussion::linkTo($post));
    }
}
