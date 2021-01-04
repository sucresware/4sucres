<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Thread;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('boards.show');
    }

    public function terms()
    {
        return view('static.terms');
    }

    public function charter()
    {
        return view('static.charter');
    }

    public function metrics()
    {
        $metrics = [
            'overall' => [
                'Nombre de membres' => User::count(),
                'Nombre de threads' => Thread::public()->count(),
                'Nombre de messages' => Post::count(),
                'Nombre de threads supprimées' => Thread::whereNotNull('deleted_at')->count(),
                'Nombre de messages supprimés' => Post::whereNotNull('deleted_at')->count(),
                'Nombre de bans en cours' => User::whereNotNull('banned_at')->count(),
            ],
            'monthly' => [
                'Nombre de nouveaux membres' => User::where('created_at', '>', now()->startOfMonth())->count(),
                'Nombre de threads' => Thread::public()->where('created_at', '>', now()->startOfMonth())->count(),
                'Nombre de messages' => Post::where('created_at', '>', now()->startOfMonth())->count(),
            ],
            'weekly' => [
                'Nombre de nouveaux membres' => User::where('created_at', '>', now()->startOfWeek())->count(),
                'Nombre de threads' => Thread::public()->where('created_at', '>', now()->startOfWeek())->count(),
                'Nombre de messages' => Post::where('created_at', '>', now()->startOfWeek())->count(),
            ],
            'daily' => [
                'Nombre de nouveaux membres' => User::where('created_at', '>', now()->startOfDay())->count(),
                'Nombre de threads' => Thread::public()->where('created_at', '>', now()->startOfDay())->count(),
                'Nombre de messages' => Post::where('created_at', '>', now()->startOfDay())->count(),
            ],
        ];

        return view('static.metrics', compact('metrics'));
    }
}
