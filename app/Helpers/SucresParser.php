<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\User;
use ForceUTF8\Encoding;
use Spatie\Regex\Regex;

class SucresParser
{
    const MENTIONS_RETURN_COMPLETE = 1;
    const MENTIONS_RETURN_USERS = 2;
    const MENTIONS_RETURN_USER_IDS = 3;
    const QUOTES_RETURN_COMPLETE = 1;
    const QUOTES_RETURN_POSTS = 2;
    const QUOTES_RETURN_POST_IDS = 3;

    public $content;
    protected $post;
    protected $parser;
    protected $protections;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->content = $post->body;
        $this->parser = new SucresParsedown();
    }

    public function render($quotes = true, $allow_html = false)
    {
        $this->parser->setSafeMode(!$allow_html);
        $this->parser->setIgnoreRegex([
            '/http(?:s|):\/\/vocaroo.com\/i\/((?:\w|-)*)/m',
            '/http(?:s|):\/\/vocabank.4sucres.(?:org|localhost)\/samples\/((?:\d|-)*)/m',
            '/http(?:s|):\/\/clips.twitch.tv\/((?:\w|-)*)/m',
            '/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/m',
            '/(?:http(?:s|):\/\/image\.noelshack\.com\/fichiers\/)(\d{4})\/(\d{2})\/(?:(\d*)\/|)((?:\w|-)*.\w*)/m',
            '/http(?:s|):\/\/(?:www\.|)strawpoll.me\/(\d+)(?:\/r|\/|)/m',
        ]);

        $this
            ->renderMD()
            ->renderEmojis()
            ->renderMentions();

        if ($quotes) {
            $this->renderQuotes();
        }

        return Encoding::toUTF8($this->content);
    }

    public function renderMD()
    {
        $this->content = $this->parser->text($this->content);

        return $this;
    }

    public function renderMentions()
    {
        foreach ($this->getMentions() as $mention) {
            if (!$mention['user']) {
                continue;
            }

            $this->content = str_replace(
                $mention['excerpt'],
                '<a href="' . $mention['user']->link . '" class="badge badge-primary align-middle">@' . $mention['user']->name . '</a>' . ' ',
                $this->content
            );
        }

        return $this;
    }

    public function renderEmojis()
    {
        $matchs = Regex::matchAll('/\:[^\s<]+(\:|)/m', $this->content);
        $poster_emojis = $this->post->user->emojis;

        foreach ($matchs->results() as $match) {
            $excerpt = $match->group(0);
            $emoji = $poster_emojis->where('shortname', $excerpt)->first();
            if (!$emoji) {
                continue;
            }

            switch ($emoji['type']) {
                case 'discord':
                    $markup = '<div class="emoji" style="background-image: url(' . $emoji['link'] . '"></div>';

                    break;
                case 'smiley':
                    $markup = '<img src="' . $emoji['link'] . '">';

                    break;
                case 'emoji':
                    $markup = $emoji['html'];

                    break;
                default:
            }

            $this->content = str_replace(
                $excerpt,
                $markup,
                $this->content
            );
        }

        return $this;
    }

    public function renderQuotes()
    {
        foreach ($this->getQuotes() as $quote) {
            if (!$quote['post']) {
                continue;
            }

            $this->content = str_replace(
                $quote['excerpt'],
                view('discussion.post._show_as_quote', array_merge(['post' => $quote['post']], ['current' => $quote['post']]))->render(),
                $this->content
            );
        }
    }

    public function getMentions($ret_type = self::MENTIONS_RETURN_COMPLETE)
    {
        $mentions = [];
        $matchs = Regex::matchAll('/(?:@|#u:)(?:(\w|-)*)/m', $this->content);

        foreach ($matchs->results() as $match) {
            $excerpt = SucresHelper::unicodeTrim($match->group(0));
            $target = SucresHelper::unicodeTrim(str_replace(['@', '#u:'], '', $excerpt));
            $user = User::where('name', $target)->first();

            if ($user && $ret_type != self::MENTIONS_RETURN_COMPLETE && $user->getIsNotifMentionAttribute()) {
                $mentions[] = self::MENTIONS_RETURN_USERS ? $user : $user->id;
            } elseif ($ret_type == self::MENTIONS_RETURN_COMPLETE) {
                $mentions[] = [
                    'excerpt' => $excerpt,
                    'user'    => $user, // /!\ Can return null if user was not found
                ];
            }
        }

        return collect($mentions);
    }

    public function hasMentions()
    {
        return count($this->getMentions(self::MENTIONS_RETURN_USER_IDS)) != 0;
    }

    public function getQuotes($ret_type = self::QUOTES_RETURN_COMPLETE)
    {
        $quotes = [];
        $matchs = Regex::matchAll('/(?:#p:)(?:(\w|-)*)/m', $this->content);

        foreach ($matchs->results() as $match) {
            $excerpt = SucresHelper::unicodeTrim($match->group(0));
            $target = SucresHelper::unicodeTrim(str_replace(['#p:'], '', $excerpt));
            $post = Post::find($target);

            if ($post && $post->discussion->private) {
                continue;
            }

            if ($post && $ret_type != self::QUOTES_RETURN_COMPLETE) {
                $quotes[] = self::QUOTES_RETURN_POSTS ? $post : $post->id;
            } elseif ($ret_type == self::QUOTES_RETURN_COMPLETE) {
                $quotes[] = [
                    'excerpt' => $excerpt,
                    'post'    => $post, // /!\ Can return null if post was not found
                ];
            }
        }

        return collect($quotes);
    }

    public function hasQuotes()
    {
        return count($this->getQuotes(self::QUOTES_RETURN_POST_IDS)) != 0;
    }

    public function getQuotedUsers()
    {
        $users = [];

        foreach ($this->getQuotes(self::QUOTES_RETURN_POSTS) as $quote) {
            if ($quote->user->getIsNotifMentionAttribute()) {
                $users[] = $quote->user;
            }
        }

        return collect($users);
    }
}
