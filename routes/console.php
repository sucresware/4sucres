<?php

use App\Models\Achievement;
use App\Models\Post;
use App\Models\thread;
use App\Models\User;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
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

// Oneshot command to convert all legacy markdown posts to bbcode
Artisan::command('convert_all_posts_from_markdown_to_bbcode', function () {
    $posts = Post::all();
    $bar = $this->output->createProgressBar(count($posts));

    foreach ($posts as $post) {
        $post->body = Regex::replace('/\*\*(.*?)\*\*/', '[b]$1[/b]', $post->body)->result();
        $post->body = Regex::replace('/\*(.*?)\*/', '[i]$1[/i]', $post->body)->result();
        $post->body = Regex::replace('/\~\~(.*?)\~\~/', '[s]$1[/s]', $post->body)->result();
        $post->body = Regex::replace('/\!\[(.*?)\]\((.*?)\)/', '$2', $post->body)->result();
        $post->body = Regex::replace('/\[(.*?)\]\((.*?)\)/', '$2', $post->body)->result();
        $post->body = Regex::replace('/\|\|(.*?)\|\|/', '[spoiler]$1[/spoiler]', $post->body)->result();
        $post->body = Regex::replace('/\%(.*?)\%/', '[mock]$1[/mock]', $post->body)->result();
        $post->body = Regex::replace('/\+(.*?)\+/', '[glitch]$1[/glitch]', $post->body)->result();
        $post->body = Regex::replace('/\~(.*?)\~/', '[vapor]$1[/vapor]', $post->body)->result();

        $post->disableLogging();
        $post->save(['timestamps' => false]);
        $bar->advance();
    }

    $bar->finish();
});

// Oneshot command to convert all legacy achievements to their new className
Artisan::command('achievements:convert', function () {
    $users = User::all();
    $bar = $this->output->createProgressBar(count($users));

    foreach ($users as $user) {
        $legacy_achivements = $user->achievements()->withPivot('unlocked_at')->get();
        $user->achievements()->detach();

        $legacy_achivements->each(function ($legacy_achivement) use ($user) {
            switch ($legacy_achivement->name) {
                case 'QUOI?!':
                    $class = \App\Achievements\Achievements\OlinuxAchievement::class;

                    break;
                case 'Bêta-Sucreur':
                    $class = \App\Achievements\Achievements\AlphaSucreAchievement::class;

                    break;
                case 'Esprit libre':
                    $class = \App\Achievements\Achievements\MindFreeAchievement::class;

                    break;
                case 'Raideur engagé':
                    $class = \App\Achievements\Achievements\RaiderAchievement::class;

                    break;
                case 'Debugger':
                    $class = \App\Achievements\Achievements\DebuggerAchievement::class;

                    break;
                case "C'est une très bonne idée":
                    $class = \App\Achievements\Achievements\VeryGoodIdeaAchievement::class;

                    break;
                case "C'est une bonne idée":
                    $class = \App\Achievements\Achievements\GoodIdeaAchievement::class;

                    break;
                case 'La CHANCE':
                    $class = \App\Achievements\Achievements\TheLuckAchievement::class;

                    break;
                case 'Tu veux du ponche ?':
                    $class = \App\Achievements\Achievements\NewcomerFromOncheAchievement::class;

                    break;
                case 'Bunkered':
                    $class = \App\Achievements\Achievements\NewcomerFromTheBunkerAchievement::class;

                    break;
                case 'Noëliste':
                    $class = \App\Achievements\Achievements\NewcomerFromHelloChrismasAchievement::class;

                    break;
                case 'ISSOU !':
                    $class = \App\Achievements\Achievements\NewcomerFromPlayVideoGamesDotComAchievement::class;

                    break;
                case 'Ça fait 6 sucres':
                    $class = \App\Achievements\Achievements\NewcomerFromTwoSugarsAchievement::class;

                    break;
            }

            $user->achievements()->attach(Achievement::where('code', (new \ReflectionClass($class))->getShortName())->first(), ['unlocked_at' => $legacy_achivement->pivot->unlocked_at]);
        });

        $bar->advance();
    }

    Achievement::where('code', '')->delete();

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

        Cache::tags('emojis')->flush();

        $this->info('Done');
    }
});

Artisan::command('fix-inconsistensies', function () {
    thread::get()->each(function ($thread) {
        $thread->replies = $thread->posts()->count();
        $thread->save();
    });
});

/*
 * Bug obscure, uniquement en production.
 * La commande orignale du package n'est pas trouvée/reconnue.
 * Du coup, voici une version alternative.
 */

Artisan::command('ban:delete-expired-alt', function () {
    $bans = Ban::query()
        ->where('expired_at', '<=', Carbon::now()->format('Y-m-d H:i:s'))
        ->get();

    $bans->each(function ($ban) {
        $ban->delete();
    });
});
