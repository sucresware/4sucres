<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

class EmojiController extends Controller
{
    public function listForUser($id)
    {
        $user = User::findOrFail($id);
        $emojis = $user->emojis;

        return response()->json($emojis);
    }
}
