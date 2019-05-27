<?php

use App\Models\Post;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Cache;
use Spatie\Regex\Regex;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

// Oneshot command to convert all legacy bbcode posts to markdown
Artisan::command('convert_all_posts_from_bbcode_to_markdown', function () {
    $posts = Post::all();
    $bar = $this->output->createProgressBar(count($posts));

    foreach ($posts as $post) {
        $çadégage = ['u', 'email', 'list', '*', 'li', 'quote', 'youtube', 'font', 'size', 'color', 'left', 'right', 'center'];

        foreach ($çadégage as $cassetoi) {
            $post->body = Regex::replace('/\[' . $cassetoi . '(?:(?:=)(.*?)|)\](.*?)\[\/' . $cassetoi . '\]/', '$2', $post->body)->result();
        }

        $post->body = Regex::replace('/\[b(?:(?:=)(.*?)|)\](.*?)\[\/b\]/', '**$2**', $post->body)->result();
        $post->body = Regex::replace('/\[i(?:(?:=)(.*?)|)\](.*?)\[\/i\]/', '*$2*', $post->body)->result();
        $post->body = Regex::replace('/\[s(?:(?:=)(.*?)|)\](.*?)\[\/s\]/', '~~$2~~', $post->body)->result();
        $post->body = Regex::replace('/\[code(?:(?:=)(.*?)|)\](.*?)\[\/code\]/', '````' . "\r\n " . '$2' . "\r\n " . '```', $post->body)->result();
        $post->body = Regex::replace('/\[url(?:(?:=)(.*?)|)\](.*?)\[\/url\]/', '[$2]($1)', $post->body)->result();
        $post->body = Regex::replace('/\[img(?:(?:=)(.*?)|)\](.*?)\[\/img\]/', '![]($2)', $post->body)->result();
        $post->body = Regex::replace('/\[spoiler(?:(?:=)(.*?)|)\](.*?)\[\/spoiler\]/', '||$2||', $post->body)->result();
        $post->body = Regex::replace('/\[mock(?:(?:=)(.*?)|)\](.*?)\[\/mock\]/', '%$2%', $post->body)->result();
        $post->body = Regex::replace('/\[glitch(?:(?:=)(.*?)|)\](.*?)\[\/glitch\]/', '@$2@', $post->body)->result();

        $post->save(['timestamps' => false]);
        $bar->advance();
    }

    $bar->finish();
});

Artisan::command('cache:rebuild {tag}', function ($tag) {
    if ($tag == 'emojis') {
        Cache::forget('jvc_smileys');
        Cache::rememberForever('jvc_smileys', function () {
            $content = File::get(base_path('resources/datasources/jvcsmileys.json'));
            $smileys = collect(json_decode($content)->smileys);

            return $smileys;
        });

        Cache::forget('emojis');
        Cache::rememberForever('emojis', function () {
            $content = File::get(base_path('resources/datasources/emojis.json'));
            $emojis = collect(json_decode($content)->emojis);
            $emojis = $emojis->reject(function ($emoji) {
                return $emoji->shortname == '';
            });

            return $emojis;
        });
    }
});
