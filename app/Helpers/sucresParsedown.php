<?php

namespace App\Helpers;

use Spatie\Regex\Regex;

class sucresParsedown extends \ParsedownCheckbox
{
    protected $urlIgnoreRegex = [];

    public function __construct()
    {
        parent::__construct();

        $this->InlineTypes['+'][] = 'Glitch';
        $this->inlineMarkerList .= '+';

        $this->InlineTypes['%'][] = 'Mock';
        $this->inlineMarkerList .= '%';

        $this->InlineTypes['|'][] = 'Spoiler';
        $this->inlineMarkerList .= '|';

        $this->InlineTypes['~'][] = 'Aesthetic';
        $this->inlineMarkerList .= '~';
    }

    protected function blockHeader($line)
    {
        return;
    }

    protected function blockSetextHeader($line, array $block = null)
    {
        return;
    }

    public function setIgnoreRegex($urlIgnoreRegex)
    {
        $this->urlIgnoreRegex = $urlIgnoreRegex;
        return $this;
    }

    protected function inlineGlitch($excerpt)
    {
        $regex = Regex::match('/^\+(.*?)\+/', $excerpt['text']);
        if ($regex->hasMatch()) {
            return [
                'extent' => strlen($regex->group(0)),
                'element' => [
                    'name' => 'span',
                    'text' => $regex->group(1),
                    'attributes' => ['class' => 'baffle',],
                ],
            ];
        }
    }

    protected function inlineMock($excerpt)
    {
        $regex = Regex::match('/^\%(.*?)\%/', $excerpt['text']);
        if ($regex->hasMatch()) {
            $str = str_split(strtolower($regex->group(1)));
            foreach ($str as &$char) {
                if (rand(0, 1)) $char = strtoupper($char);
            }

            return [
                'extent' => strlen($regex->group(0)),
                'element' => [
                    'name' => 'span',
                    'text' => implode('', $str),
                ],
            ];
        }
    }

    protected function inlineSpoiler($excerpt)
    {
        $regex = Regex::match('/^\|\|(.*?)\|\|/', $excerpt['text']);
        if ($regex->hasMatch()) {

            return [
                'extent' => strlen($regex->group(0)),
                'element' => [
                    'name' => 'span',
                    'text' => $regex->group(1),
                    'attributes' => ['class' => 'spoiler',],
                ],
            ];
        }
    }

    protected function inlineAesthetic($excerpt)
    {
        $regex = Regex::match('/^\~(.*?)\~/', $excerpt['text']);

        if ($regex->hasMatch()) {
            $input = transliterator_transliterate('Any-Latin; Latin-ASCII;', $regex->group(1));
            $output = '';
            for ($i = 0; $i < strlen($input); $i++) {
                $char = $input[$i];
                list(, $code) = unpack('N', mb_convert_encoding($char, 'UCS-4BE', 'UTF-8'));
                if ($code >= 33 && $code <= 270) {
                    $output .= mb_convert_encoding('&#' . intval($code + 65248) . ';', 'UTF-8', 'HTML-ENTITIES');
                } elseif ($code == 32) {
                    $output .= chr($code);
                }
            }

            return [
                'extent' => strlen($regex->group(0)),
                'element' => [
                    'name' => 'span',
                    'text' => trim($output),
                ],
            ];
        }
    }

    protected function inlineUrl($excerpt)
    {
        $link = parent::inlineUrl($excerpt);
        if (!isset($link)) return null;

        foreach ($this->urlIgnoreRegex as $regex) {
            if (Regex::match($regex, $link['element']['attributes']['href'])->hasMatch()) {
                $link['markup'] = $this->renderEmbed($link['element']['attributes']['href']);
                return $link;
            }
        }

        return $link;
    }

    protected function inlineLink($excerpt)
    {
        $link = parent::inlineLink($excerpt);
        if (!isset($link)) return null;

        if ($link['element']['text'] == '') {
            $link['element']['text'] = $link['element']['attributes']['href'];
        }

        $url = $link['element']['attributes']['href'];

        if ($link['element']['text'] != $url) {
            $preview = '<i class="fas fa-exclamation-triangle text-warning mr-1"></i> ' . '<a href="#">$url</a>';
        } else {
            $preview = '<i class="fas fa-check-circle text-success mr-1"></i> ' . '<a href="#">$url</a>';
        }

        $link['markup'] = "<a target='_blank' href='$url' data-toggle='tooltip' data-placement='top' data-html='true' title='$preview'>" . $link['element']['text'] . '</a>';

        return $link;
    }

    protected function inlineImage($excerpt)
    {
        $image = parent::inlineImage($excerpt);

        if (!isset($image)) return null;

        $url = $image['element']['attributes']['src'];
        $url = str_replace("http://", "https://", $url);

        $regex = Regex::match('/(?:http(?:s|):\/\/image\.noelshack\.com\/fichiers\/)(\d{4})\/(\d{2})\/(?:(\d*)\/|)((?:\w|-)*.\w*)/s', $url);

        if ($regex->hasMatch()) {
            if (auth()->check() && user()->getSetting('layout.stickers', 'default') == 'inline') {
                $preview = '<img class="sticker" src="' . $url . '">';
                $image['markup'] = "<img class='sticker-inline tooltip-inverse' src='$url' data-toggle='tooltip' data-placement='top' data-html='true' title='$preview'>";
            } else {
                $image['markup'] = "<img class='sticker' src='$url'>";
            }
        } else {
            $image['markup'] = "<a href='$url' data-toggle='fancybox' data-type='image' class='my-2'><img src='$url' class='img-fluid'></a>";
        }

        return $image;
    }

    public function renderEmbed($link)
    {
        $link = $this->renderYoutube($link);
        $link = $this->renderVocaroo($link);
        $link = $this->renderTwitchClips($link);
        $link = $this->renderVocaBank($link);
        $link = $this->renderNoelshack($link);
        return $link;
    }

    public function renderYoutube($link)
    {
        $matchs = Regex::matchAll('/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/m', $link);

        foreach ($matchs->results() as $match) {
            $markup  = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $match->group(1) . '?rel=0" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-youtube text-danger"></i> <a target="_blank" href="' . $match->group(0) . '">Ouvrir dans YouTube</a></div>';
            $markup .= '</div>';

            return $markup;
        }

        return $link;
    }

    public function renderVocaroo($link)
    {
        $matchs = Regex::matchAll('/http(?:s|):\/\/vocaroo.com\/i\/((?:\w|-)*)/m', $link);
        foreach ($matchs->results() as $match) {
            $markup  = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div style="max-width: 500px" class="border-bottom">';
            $markup .= '<audio controls="controls" volume="0.5" style="width: 100%; max-width: 500px">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $match->group(1) . '&command=download_mp3" type="audio/mpeg">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $match->group(1) . '&command=download_webm" type="audio/webm"></audio>';
            $markup .= '</audio>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-microphone text-success"></i> <a target="_blank" href="' . $match->group(0) . '">Écouter sur Vocaroo</a></div>';
            $markup .= '</div>';

            return $markup;
        }

        return $link;
    }

    public function renderTwitchClips($link)
    {
        $matchs = Regex::matchAll('/http(?:s|):\/\/clips.twitch.tv\/((?:\w|-)*)/m', $link);

        foreach ($matchs->results() as $match) {
            $markup  = '<div class="integration my-2 shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://clips.twitch.tv/embed?autoplay=false&clip=' . $match->group(1) . '" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-twitch" style="color: #4b367c"></i> <a target="_blank" href="' . $match->group(0) . '">Ouvrir dans Twitch</a></div>';
            $markup .= '</div>';

            return $markup;
        }

        return $link;
    }

    public function renderVocaBank($link)
    {
        $matchs = Regex::matchAll('/http(?:s|):\/\/vocabank.4sucres.(?:org|localhost)\/samples\/((?:\d|-)*)/m', $link);

        foreach ($matchs->results() as $match) {
            $markup  = '<div class="integration my-2 shadow-sm" style="max-width: 600px">';
            $markup .= '<div style="max-width: 600px" class="border-bottom">';
            $markup .= '<iframe width="100%" height="120" scrolling="no" frameborder="no" src="' . $match->group(0) . '/iframe"></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-microphone text-primary"></i> <a target="_blank" href="' . $match->group(0) . '">Écouter sur VocaBank</a></div>';
            $markup .= '</div>';

            return $markup;
        }

        return $link;
    }

    public function renderNoelshack($link)
    {
        $matchs = Regex::matchAll('/(?:http(?:s|):\/\/image\.noelshack\.com\/fichiers\/)(\d{4})\/(\d{2})\/(?:(\d*)\/|)((?:\w|-)*.\w*)/s', $link);
        foreach ($matchs->results() as $match) {
            if (auth()->check() && user()->getSetting('layout.stickers', 'default') == 'inline') {
                $preview = '<img class="sticker" src="' . $match->group(0) . '">';
                $markup = "<img class='sticker-inline tooltip-inverse' src='" . $match->group(0) . "' data-toggle='tooltip' data-placement='top' data-html='true' title='$preview'>";
            } else {
                $markup = "<img class='sticker' src='" . $match->group(0) . "'>";
            }

            return $markup;
        }

        return $link;
    }
}
