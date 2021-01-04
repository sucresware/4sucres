<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewPrivatethread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrivatethreadController extends Controller
{
    public function index()
    {
        $private_threads = thread::private(user())->get();

        $user_has_read = DB::table('has_read_threads_users')
            ->select('thread_id')
            ->where('user_id', user()->id)
            ->whereIn('thread_id', $private_threads->pluck('id'))
            ->pluck('thread_id')
            ->toArray();

        return view('thread.private.index', compact('private_threads', 'user_has_read'));
    }

    public function create(User $user)
    {
        if (user()->restricted) {
            return redirect()->route('home')->with('error', 'Tout doux bijou ! Tu dois vérifier ton adresse email avant créer un topic !');
        }

        $from = user();
        $to = $user;

        return view('thread.private.create', compact('from', 'to'));
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

        $thread = thread::create([
            'title' => request()->title,
            'user_id' => user()->id,
            'board_id' => 0,
            'private' => true,
        ]);

        $post = $thread->posts()->create([
            'body' => request()->body,
            'user_id' => user()->id,
        ]);

        $thread->members()->attach([$from->id, $to->id]);
        $thread->subscribed()->syncWithoutDetaching([$from->id, $to->id]);

        $to->notify(new NewPrivatethread($thread));

        return redirect($post->link);
    }
}
