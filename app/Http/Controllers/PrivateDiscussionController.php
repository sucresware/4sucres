<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Models\Discussion;
use App\Models\User;
use App\Notifications\NewPrivateDiscussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrivateDiscussionController extends Controller
{
    public function index()
    {
        $private_discussions = Discussion::private(user())->get();

        $user_has_read = DB::table('has_read_discussions_users')
            ->select('discussion_id')
            ->where('user_id', user()->id)
            ->whereIn('discussion_id', $private_discussions->pluck('id'))
            ->pluck('discussion_id')
            ->toArray();

        return view('discussion.private.index', compact('private_discussions', 'user_has_read'));
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
            'body' => 'required|min:3',
        ]);

        SucresHelper::throttleOrFail(__METHOD__, 5, 1);

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
        $discussion->subscribed()->syncWithoutDetaching([$from->id, $to->id]);

        $to->notify(new NewPrivateDiscussion($discussion));

        return redirect($post->link);
    }
}
