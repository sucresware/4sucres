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
        $this->content = e($post->body);
        $this->parser = new \ChrisKonnertz\BBCode\BBCode();

        $this->parser->ignoreTag('code');
        $this->parser->ignoreTag('url');
        $this->parser->ignoreTag('email');
        $this->parser->ignoreTag('quote');
        $this->parser->ignoreTag('img');
        $this->parser->ignoreTag('youtube');
        $this->parser->ignoreTag('font');
        $this->parser->ignoreTag('size');
        $this->parser->ignoreTag('color');

        $this->parser->addTag('mock', function ($tag) {
            return $tag->opening ? '[mock]' : '[/mock]';
        });
        $this->parser->addTag('glitch', function ($tag) {
            return $tag->opening ? '[glitch]' : '[/glitch]';
        });
        $this->parser->addTag('vapor', function ($tag) {
            return $tag->opening ? '[vapor]' : '[/vapor]';
        });
    }

    public function render($quotes = true, $allow_html = false)
    {
        $this
            ->parse()
            ->renderCustomTags()
            ->renderEmbeds()
            ->linkify()
            ->renderEmojis()
            ->renderMentions();

        if ($quotes) {
            $this->renderQuotes();
        }

        return Encoding::toUTF8($this->content);
    }

    public function parse()
    {
        $this->content = $this->parser->render($this->content);

        return $this;
    }

    public function renderCustomTags()
    {
        return $this
            ->renderMock()
            ->renderGlitch()
            ->renderAesthetic();
    }

    public function renderEmbeds()
    {
        return $this
            ->renderYouTube()
            ->renderVocaroo()
            ->renderTwitchClips()
            ->renderNoelshack()
            ->renderStrawpoll();
    }

    public function linkify()
    {
        $this->content = linkify($this->content);

        return $this;
    }

    public function renderMock()
    {
        $regex = Regex::match('/(?:\[mock\])(.*?)(?:\[\/mock\])/', $this->content);
        if ($regex->hasMatch()) {
            $str = str_split(strtolower($regex->group(1)));
            foreach ($str as &$char) {
                if (rand(0, 1)) {
                    $char = strtoupper($char);
                }
            }

            $this->content = str_replace(
                $regex->group(0),
                implode('', $str),
                $this->content
            );
        }

        return $this;
    }

    public function renderGlitch()
    {
        $regex = Regex::match('/(?:\[glitch\])(.*?)(?:\[\/glitch\])/', $this->content);
        if ($regex->hasMatch()) {
            $this->content = str_replace(
                $regex->group(0),
                '<span class="wow baffle">' . $regex->group(1) . '</span>',
                $this->content
            );
        }

        return $this;
    }

    public function renderAesthetic()
    {
        $regex = Regex::match('/(?:\[vapor\])(.*?)(?:\[\/vapor\])/', $this->content);
        if ($regex->hasMatch()) {
            $input = transliterator_transliterate('Any-Latin; Latin-ASCII;', $regex->group(1));
            $output = '';
            for ($i = 0; $i < strlen($input); ++$i) {
                $char = $input[$i];
                list(, $code) = unpack('N', mb_convert_encoding($char, 'UCS-4BE', 'UTF-8'));
                if ($code >= 33 && $code <= 270) {
                    $output .= mb_convert_encoding('&#' . intval($code + 65248) . ';', 'UTF-8', 'HTML-ENTITIES');
                } elseif ($code == 32) {
                    $output .= chr($code);
                }
            }

            $this->content = str_replace(
                $regex->group(0),
                trim($output),
                $this->content
            );
        }

        return $this;
    }

    public function renderYouTube()
    {
        $matchs = Regex::matchAll('/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/m', $this->content);

        foreach ($matchs->results() as $match) {
            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $match->group(1) . '?rel=0" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-youtube text-danger"></i> <a target="_blank" href="' . $match->group(0) . '">Ouvrir dans YouTube</a></div>';
            $markup .= '</div>';

            $this->content = str_replace(
                $match->group(0),
                $markup,
                $this->content
            );
        }

        return $this;
    }

    public function renderVocaroo()
    {
        $matchs = Regex::matchAll('/http(?:s|):\/\/vocaroo.com\/i\/((?:\w|-)*)/m', $this->content);
        foreach ($matchs->results() as $match) {
            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div style="max-width: 500px" class="border-bottom">';
            $markup .= '<audio controls="controls" volume="0.5" style="width: 100%; max-width: 500px">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $match->group(1) . '&command=download_mp3" type="audio/mpeg">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $match->group(1) . '&command=download_webm" type="audio/webm"></audio>';
            $markup .= '</audio>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-microphone text-success"></i> <a target="_blank" href="' . $match->group(0) . '">Écouter sur Vocaroo</a></div>';
            $markup .= '</div>';

            $this->content = str_replace(
                $match->group(0),
                $markup,
                $this->content
            );
        }

        return $this;
    }

    public function renderTwitchClips()
    {
        $matchs = Regex::matchAll('/http(?:s|):\/\/clips.twitch.tv\/((?:\w|-)*)/m', $this->content);

        foreach ($matchs->results() as $match) {
            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://clips.twitch.tv/embed?autoplay=false&clip=' . $match->group(1) . '" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-twitch" style="color: #4b367c"></i> <a target="_blank" href="' . $match->group(0) . '">Ouvrir dans Twitch</a></div>';
            $markup .= '</div>';

            $this->content = str_replace(
                $match->group(0),
                $markup,
                $this->content
            );
        }

        return $this;
    }

    public function renderNoelshack()
    {
        $matchs = Regex::matchAll('/(?:http(?:s|):\/\/image\.noelshack\.com\/fichiers\/)(\d{4})\/(\d{2})\/(?:(\d*)\/|)((?:\w|-)*.\w*)/s', $this->content);
        foreach ($matchs->results() as $match) {
            if (auth()->check() && user()->getSetting('layout.stickers', 'default') == 'inline') {
                $preview = '<img class="sticker" src="' . $match->group(0) . '">';
                $markup = "<img class='sticker-inline tooltip-inverse' src='" . $match->group(0) . "' data-toggle='tooltip' data-placement='top' data-html='true' title='$preview'>";
            } else {
                $markup = "<img class='sticker' src='" . $match->group(0) . "'>";
            }

            $this->content = str_replace(
                $match->group(0),
                $markup,
                $this->content
            );
        }

        return $this;
    }

    public function renderStrawpoll()
    {
        $matchs = Regex::matchAll('/http(?:s|):\/\/(?:www\.|)strawpoll.me\/(\d+)(?:\/r|\/|)/m', $this->content);

        foreach ($matchs->results() as $match) {
            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 680px">';
            $markup .= '<div style="max-width: 680px" class="border-bottom d-none d-lg-block">';
            $markup .= '<iframe style="width:680px; height:457px; border:0;" scrolling="no" frameborder="no" src="https://www.strawpoll.me/embed_1/' . $match->group(1) . '/r"></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="border-bottom d-lg-none p-2 text-center" style="background-color: #ffd756">';
            $markup .= '<a color="#000" target="_blank" href="' . $match->group(0) . '">' . $match->group(0) . '</a>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-chart-pie" color="#ca302c"></i> <a target="_blank" href="' . $match->group(0) . '">Voter sur StrawPoll</a></div>';
            $markup .= '</div>';

            $this->content = str_replace(
                $match->group(0),
                $markup,
                $this->content
            );
        }

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
                    $markup = '<span class="emoji" style="background-image: url(' . $emoji['link'] . ')"></span>';

                    break;
                case 'smiley':
                    $markup = '<img src="' . $emoji['link'] . '" style="vertical-align: middle;">';

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
            $excerpt = trim($match->group(0));
            $target = trim(str_replace(['@', '#u:'], '', $excerpt));
            $user = User::where('name', $target)->first();

            if ($user && $ret_type != self::MENTIONS_RETURN_COMPLETE) {
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
            $excerpt = trim($match->group(0));
            $target = trim(str_replace(['#p:'], '', $excerpt));
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
            $users[] = $quote->user;
        }

        return collect($users);
    }
}
