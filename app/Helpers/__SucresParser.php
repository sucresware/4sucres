<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\User;
use ForceUTF8\Encoding;
use Spatie\Regex\Regex;

class SucresParser
{
    public $content;

    protected $post;

    protected $parser;

    protected $lightweight;

    protected $protections;

    public function __construct(Post $post, $lightweight = false)
    {
        $this->post = $post;
        $this->content = $post->body;
        $this->lightweight = $lightweight;
        $this->parser = new SucresParsedown();
    }

    public function render()
    {
        $this->parser->setSafeMode(true);
        $this->parser->setIgnoreRegex([
            '/http(?:s|):\/\/vocaroo.com\/i\/((?:\w|-)*)/m',
            '/http(?:s|):\/\/vocabank.4sucres.(?:org|localhost)\/samples\/((?:\d|-)*)/m',
            '/http(?:s|):\/\/clips.twitch.tv\/((?:\w|-)*)/m',
            '/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/m',
            '/(?:http(?:s|):\/\/image\.noelshack\.com\/fichiers\/)(\d{4})\/(\d{2})\/(?:(\d*)\/|)((?:\w|-)*.\w*)/m',
        ]);

        $this->renderMD()
            ->renderMentions();

        if (!$this->lightweight) {
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
        $matchs = Regex::matchAll('/(?:@|#u:)(?:(\w|-)*)/m', $this->content);

        foreach ($matchs->results() as $match) {
            $tag = trim($match->group(0));
            $clear_tag = trim(str_replace(['@', '#u:'], '', $tag));

            $user = User::where('name', $clear_tag)->first();
            if (!$user) {
                continue;
            }

            $this->content = str_replace(
                $tag,
                '<a href="' . $user->link . '" class="badge badge-primary align-middle">@' . $user->name . '</a>' . ' ',
                $this->content
            );
        }
    }

    public function renderQuotes()
    {
        $matchs = Regex::matchAll('/(?:#p:)(?:(\w|-)*)/m', $this->content);

        foreach ($matchs->results() as $match) {
            $tag = trim($match->group(0));
            $clear_tag = trim(str_replace(['#p:'], '', $tag));

            $post = Post::find($clear_tag);
            if (!$post || $post->discussion->private) {
                continue;
            }

            $this->content = str_replace(
                $tag,
                view('discussion.post._show_as_quote', array_merge(compact('post'), ['current' => $this->post]))->render(),
                $this->content
            );
        }
    }
}
