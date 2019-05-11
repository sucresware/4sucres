<?php

namespace App\Helpers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class sucresParser
{
    public $content;
    protected $bbcode_parser;
    protected $lightweight;
    protected $protections;

    public function __construct($content, $lightweight = false)
    {
        $this->content = $content;
        $this->lightweight = $lightweight;
        $this->parser = new \ChrisKonnertz\BBCode\BBCode();
        $this->protections = [];
    }

    public function render(){
        $this->addBBCodesToParser()
             ->renderMock()
             ->protectAttr('youtube')
             ->protectAttr('url')
             ->renderBB()
             ->renderUrl()
             ->renderYoutube()
             ->renderVocaroo()
             ->renderMentions();

        if (!$this->lightweight) {
            $this->renderQuotes();
        }

        return $this->content;
    }

    public function addBBCodesToParser(){
        $this->parser->addTag('glitch', function ($tag, &$html, $openingTag) {
            if ($tag->opening) {
                return '<span class="baffle">';
            } else {
                return '</span>';
            }
        });

        return $this;
    }

    public function renderBB(){
        $this->content = $this->parser->render($this->content);

        return $this;
    }

    public function renderMock(){
        $preg_result = [];
        $regexp = '/(?:\[mock\])(.*?)(?:\[\/mock\])/';
        preg_match_all($regexp, $this->content, $preg_result);

        foreach ($preg_result[0] as $k => $tag) {
            $str = str_split(strtolower($preg_result[1][$k]));
            foreach ($str as &$char) {
                if (rand(0, 1)) {
                    $char = strtoupper($char);
                }
            }

            $this->content = str_replace(
                $tag, implode('', $str), $this->content
            );
        }

        return $this;
    }

    public function renderUrl(){
        $preg_result = [];
        $regexp = '/{' . $this->protections['url'] . '(=.*?|)}(.*?){\/' . $this->protections['url'] . '}/';
        preg_match_all($regexp, $this->content, $preg_result);

        foreach ($preg_result[0] as $k => $match) {
            $url = $preg_result[1][$k] == '' ? $preg_result[2][$k] : $preg_result[1][$k];
            $url = trim($url, '=');
            if ($preg_result[1][$k] != '' && $url != $preg_result[2][$k]) {
                $preview = '<i class="fas fa-exclamation-triangle text-warning mr-1"></i> ' . $url;
            } else {
                $preview = '<i class="fas fa-check-circle text-success mr-1"></i> ' . $url;
            }
            $markup = "<a target='_blank' href='$url' data-toggle='tooltip' data-placement='top' data-html='true' title='$preview'>" . $preg_result[2][$k] . '</a>';
            $this->content = str_replace($preg_result[0][$k], $markup, $this->content);
        }

        return $this;
    }

    public function renderYoutube(){
        $preg_result = [];
        $regexp = '/{' . $this->protections['youtube'] . '(=.*?|)}(.*?){\/' . $this->protections['youtube'] . '}/';
        preg_match_all($regexp, $this->content, $preg_result);

        foreach ($preg_result[0] as $k => $match) {
            $youtube_id = $base_youtube_url = $preg_result[2][$k];
            $youtube_id = str_replace('https://www.youtube.com/watch?v=', '', $youtube_id);
            $youtube_id = str_replace('https://youtube.com/watch?v=', '', $youtube_id);
            $youtube_id = str_replace('https://youtu.be/', '', $youtube_id);
            $youtube_id = str_replace('https://www.youtube.com/embed/', '', $youtube_id);
            $youtube_id = str_replace('http://www.youtube.com/watch?v=', '', $youtube_id);
            $youtube_id = str_replace('http://youtube.com/watch?v=', '', $youtube_id);
            $youtube_id = str_replace('http://youtu.be/', '', $youtube_id);
            $youtube_id = str_replace('http://www.youtube.com/embed/', '', $youtube_id);
            $youtube_id = trim(explode('&', $youtube_id)[0]);

            $markup  = '<div class="integration shadow-sm" style="max-width: 500px">';
            $markup .= '<div class="embed-responsive embed-responsive-16by9" style="max-width: 500px">';
            $markup .= '<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $youtube_id . '?rel=0" allowfullscreen></iframe>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fab fa-youtube text-danger"></i> <a target="_blank" href="' . $base_youtube_url . '">Ouvrir dans YouTube</a></div>';
            $markup .= '</div>';

            $this->content = str_replace($preg_result[0][$k], $markup, $this->content);
        }

        return $this;
    }

    public function renderVocaroo(){
        $preg_result = [];
        $regexp = '/http(?:s|):\/\/vocaroo.com\/i\/((?:\w|-)*)/m';
        preg_match_all($regexp, $this->content, $preg_result);

        foreach ($preg_result[0] as $k => $match) {
            $base_vocaroo_url = $preg_result[0][$k];
            $vocaroo_id = $preg_result[1][$k];

            $markup  = '<div class="integration shadow-sm" style="max-width: 500px">';
            $markup .= '<div style="max-width: 500px" class="border-bottom">';
            $markup .= '<audio controls="controls" style="width: 100%; max-width: 500px">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $vocaroo_id . '&command=download_mp3" type="audio/mpeg">';
            $markup .= '<source src="https://vocaroo.com/media_command.php?media=' . $vocaroo_id . '&command=download_webm" type="audio/webm"></audio>';
            $markup .= '</audio>';
            $markup .= '</div>';
            $markup .= '<div class="integration-text"><i class="fas fa-microphone text-success"></i> <a target="_blank" href="' . $base_vocaroo_url . '">Écouter sur Vocaroo</a></div>';
            $markup .= '</div>';

            $this->content = str_replace($preg_result[0][$k], $markup, $this->content);
        }

        return $this;
    }

    public function renderMentions(){
        $preg_result = [];
        $regex = '/(?:@|#u:)(?:(\w|-)*)/m';
        preg_match_all($regex, $this->content, $preg_result);

        foreach ($preg_result[0] as $tag) {
            $tag = trim($tag);
            $clear_tag = trim(str_replace(['@', '#u:'], '', $tag));

            $user = User::where('name', $clear_tag)->first();
            if (!$user) { continue; }

            $this->content = str_replace(
                $tag, '<a href="' . $user->link . '" class="badge badge-primary">@' . $user->name . '</a>' . ' ', $this->content
            );
        }
    }

    public function renderQuotes(){
        $preg_result = [];
        $regex = '/(?:#p:)(?:(\w|-)*)/m';
        preg_match_all($regex, $this->content, $preg_result);

        foreach ($preg_result[0] as $tag) {
            $tag = trim($tag);
            $clear_tag = trim(str_replace(['#p:'], '', $tag));

            $post = Post::find($clear_tag);
            if (!$post || $post->discussion->private) {
                continue;
            }

            $this->content = str_replace(
                $tag, view('discussion.post._show_as_quote', compact('post'))->render(), $this->content
            );
        }
    }

    public function protectAttr($attr){
        $attr_code = Str::uuid()->toString();

        $regexp = '/\[' . $attr . '(=.*?|)\](.*?)\[\/' . $attr . '\]/';
        $subst = '{' . $attr_code . '$1}$2{/' . $attr_code . '}';

        $this->content = preg_replace($regexp, $subst, $this->content);
        $this->protections[$attr] = $attr_code;

        return $this;
    }

}
