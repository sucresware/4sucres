<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\User;
use ForceUTF8\Encoding;
use Illuminate\Support\Str;
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
    protected $replacements;

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

        $this->replacements = [];
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

        $this
            ->performReplacements();

        return Encoding::toUTF8($this->content);
    }

    public function parse()
    {
        $this->content = $this->parser->render($this->content);

        return $this;
    }

    public function performReplacements()
    {
        $this->content = str_replace(
            array_keys($this->replacements),
            $this->replacements,
            $this->content
        );

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
            ->renderVocaBank()
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
        $pattern = '/(?:\[mock\])(.*?)(?:\[\/mock\])/';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $str = str_split(strtolower($match->group(1)));
            foreach ($str as &$char) {
                $char = rand(0, 1) ? strtoupper($char) : $char;
            }

            $this->replacements[$uuid] = implode('', $str);

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderGlitch()
    {
        $pattern = '/(?:\[glitch\])(.*?)(?:\[\/glitch\])/';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $this->replacements[$uuid] = '<span class="wow baffle">' . $match->group(1) . '</span>';

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderAesthetic()
    {
        $pattern = '/(?:\[vapor\])(.*?)(?:\[\/vapor\])/';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $input = transliterator_transliterate('Any-Latin; Latin-ASCII;', $match->group(1));
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

            $this->replacements[$uuid] = trim($output);

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderYouTube()
    {
        $pattern = '/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;|)[\w\=]*)?/m';
        $matchs = Regex::matchAll($pattern, $this->content);

        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $match->group(1) . '?rel=0" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-youtube text-danger"></i> <a target="_blank" href="https://www.youtube.com/watch?v=' . $match->group(1) . '">Ouvrir dans YouTube</a></div>';
            $markup .= '</div>';

            $this->replacements[$uuid] = $markup;

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderVocaroo()
    {
        $pattern = '/http(?:s|):\/\/vocaroo\.com\/i\/((?:\w|-)*)/m';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div style="max-width: 500px" class="border-bottom">';
            $markup .= '<audio controls="controls" volume="0.5" style="width: 100%; max-width: 500px">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $match->group(1) . '&command=download_mp3" type="audio/mpeg">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $match->group(1) . '&command=download_webm" type="audio/webm"></audio>';
            $markup .= '</audio>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-microphone text-success"></i> <a target="_blank" href="https://vocaroo.com/i/' . $match->group(1) . '">Écouter sur Vocaroo</a></div>';
            $markup .= '</div>';

            $this->replacements[$uuid] = $markup;

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderVocaBank()
    {
        $pattern = '/http(?:s|):\/\/vocabank\.org\/samples\/((?:\w|-)*)/m';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div style="max-width: 500px" class="border-bottom">';
            $markup .= '<iframe style="width: 100%; height:200px; border:0;" scrolling="no" frameborder="no" src="https://vocabank.org/samples/' . $match->group(1) . '/iframe"></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-undo"></i> <a target="_blank" href="https://vocabank.org/samples/' . $match->group(1) . '">Ouvrir sur VocaBank</a></div>';
            $markup .= '</div>';

            $this->replacements[$uuid] = $markup;

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderTwitchClips()
    {
        $pattern = '/http(?:s|):\/\/clips\.twitch\.tv\/((?:\w|-)*)/m';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://clips.twitch.tv/embed?autoplay=false&clip=' . $match->group(1) . '" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-twitch" style="color: #4b367c"></i> <a target="_blank" href="https://clips.twitch.tv/' . $match->group(1) . '">Ouvrir dans Twitch</a></div>';
            $markup .= '</div>';

            $this->replacements[$uuid] = $markup;

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderNoelshack()
    {
        $pattern = '/(?:http(?:s|):\/\/image\.noelshack\.com\/fichiers\/)(\d{4})\/(\d{2})\/(?:(\d*)\/|)((?:\w|-)*.\w*)/s';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            if (auth()->check() && user()->getSetting('layout.stickers', 'default') == 'inline') {
                $preview = '<img class="sticker" src="' . $match->group(0) . '">';
                $markup = "<img class='sticker-inline tooltip-inverse' src='" . $match->group(0) . "' data-toggle='tooltip' data-placement='top' data-html='true' title='$preview'>";
            } else {
                $markup = "<img class='sticker' src='" . $match->group(0) . "'>";
            }

            $lightbox = "<a href='" . $match->group(0) . "' data-toggle='lightbox' data-type='image' class='my-2'>" . $markup . '</a>';
            $this->replacements[$uuid] = $lightbox;

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
                $this->content
            );
        }

        return $this;
    }

    public function renderStrawpoll()
    {
        $pattern = '/http(?:s|):\/\/(?:www\.|)strawpoll\.me\/(\d+)(?:\/r|\/|)/m';

        $matchs = Regex::matchAll($pattern, $this->content);
        foreach ($matchs->results() as $match) {
            $uuid = (string) Str::uuid();

            $markup = '<div class="integration my-2 shadow-sm" style="max-width: 680px">';
            $markup .= '<div style="max-width: 680px" class="border-bottom d-none d-lg-block">';
            $markup .= '<iframe style="width:680px; height:457px; border:0;" scrolling="no" frameborder="no" src="https://www.strawpoll.me/embed_1/' . $match->group(1) . '/r"></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="border-bottom d-lg-none p-2 text-center" style="background-color: #ffd756">';
            $markup .= '<a color="#000" target="_blank" href="https://www.strawpoll.me/' . $match->group(1) . '">https://www.strawpoll.me/' . $match->group(1) . '</a>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-chart-pie" color="#ca302c"></i> <a target="_blank" href="https://www.strawpoll.me/' . $match->group(1) . '">Voter sur StrawPoll</a></div>';
            $markup .= '</div>';

            $this->replacements[$uuid] = $markup;

            $this->content = Str::replaceFirst(
                $match->group(0),
                $uuid,
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

            $uuid = (string) Str::uuid();

            $this->replacements[$uuid] = '<a href="' . $mention['user']->link . '" class="badge badge-primary align-middle">@' . $mention['user']->name . '</a>' . ' ';

            $this->content = Str::replaceFirst(
                $mention['excerpt'],
                $uuid,
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

            $this->content = Str::replaceFirst(
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

            $uuid = (string) Str::uuid();

            $this->replacements[$uuid] = view('discussion.post._show_as_quote', array_merge(['post' => $quote['post']], ['current' => $quote['post']]))->render();

            $this->content = Str::replaceFirst(
                $quote['excerpt'],
                $uuid,
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
