<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Discussion;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\DomCrawler\Crawler;
use CloudflareBypass\RequestMethod\CFCurl;

class BunkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $browse_account = 'cookie: remember_user_token=eyJfcmFpbHMiOnsibWVzc2FnZSI6IlcxczJOalkzWFN3aUpESmhKREV4SkRCMEwyOW5kM1pwVERKcGNXUk5jVWhLTG1sd01FOGlMQ0l4TlRVMk9UQXlOVFkxTGpreE5qY3dNRFFpWFE9PSIsImV4cCI6IjIwMTktMDUtMTdUMTY6NTY6MDUuOTE2WiIsInB1ciI6bnVsbH19--678612757ffc5a85973fa0e75bbeb4be09089513; _lebunker_session=K1%2BXtn3tL1%2FihqfcnoA5tu9T%2B5agJ0GSAMNjcx1RCSfykr26LN4xMRnbNRoev8lkZAIFNOPdIhlaNPUelhRUiGLVidYBgcuAQYplcHlEP8jPBc6n5SzroCv29N0HbKc%2BQMN%2Bo3j4f8aKJNfpeHAkiM1FYMMILtzyvXed8GE%2FxC3F7bn9CulBweoa7hiflu5CAH7aOpo71TbrItOnDegwlrbk8wBRDWAXKL1UTzG1--S8IBbtIzfbnl66%2Bw--OtVFK1m3f6xsVenNc8aoig%3D%3D;';

        echo ('_____ _____ _____ _____ _____ _____ _____ ____    ');
        echo ('| __  |  |  |   | |  |  |   __| __  |   __|    \  ');
        echo ('| __ -|  |  | | | |    -|   __|    -|   __|  |  | ');
        echo ('|_____|_____|_|___|__|__|_____|__|__|_____|____/  ');

        $_from = 1;
        $_limit = 3;
        echo ("Listing topics (" . $_limit . " pages from " . $_from . "):");

        $topics = collect([]);
        for ($page = $_from; $page <= $_limit; $page++) {
            $topics = $topics->merge($this->list_topics($page, $browse_account));
            echo ".";
        }
        echo "\r\n";

        $topics->each(function ($topic) use ($browse_account) {
            $user = User::where('name', $topic->user)->first();
            if ($user == null) {
                $user = User::create([
                    'name' => $topic->user,
                    'display_name' => $topic->user,
                    'email' => rand(0, 50000000),
                    'password' => '---',
                    'remember_token' => '---'
                ]);
            }

            Discussion::create([
                'title' => $topic->name,
                'user_id' => $user->id,
            ]);

            echo ('Parsing topic: ' . $topic->name);
            $this->parse_topic($topic, $browse_account);
        });


    }

    public function list_topics($page, $browse_account)
    {
        $dom = $this->curl_this('/forum?page=' . $page, $browse_account);
        $crawler = new Crawler($dom);
        $topics = $crawler->filter('table.list-posts')->filter('tbody>tr')->each(function ($node) {
            $topic = new stdClass();
            $topic->name = trim(implode('', explode("\n", $node->filter('.post-name')->text())));
            $topic->user = trim(implode('', explode("\n", $node->filter('.post-user')->text())));
            $topic->href = $node->filter('.post-name>a')->attr('href');

            return $topic;
        });
        return collect($topics);
    }

    public function parse_topic($topic, $browse_account)
    {
        $ignored_topics = [
            '/forum/0-feedback-balancer-vos-ameliorations-pour-lebunker-net',
            '/forum/0-maintenir-lebunker-net-en-vie',
            '/forum/0-tournois-sur-skribbl-io',
            '/forum/0-topics-sans-interet-pulluants-ban-1-jour',
        ];

        if (in_array($topic->href, $ignored_topics)) {
            return null;
        }

        $dom = $this->curl_this($topic->href, $browse_account);
        $crawler = new Crawler($dom);

        try {
            $pages = (int) $crawler->filter('div.pagination')->filter('li.not-selected')->last()->text();
        } catch (\Exception $e) {
            $pages = 1;
        }

        for ($page=1; $page <= $pages; $page++) {
            $this->list_posts_on_page($topic, $page, $browse_account);
        }
    }

    public function list_posts_on_page($topic, $page, $browse_account)
    {
        $dom = $this->curl_this($topic->href . '?page=' . $page, $browse_account);
        $crawler = new Crawler($dom);

        $posts = $crawler->filter('.row>.col-sm-12>.card')->each(function ($node) use ($topic) {
            echo ".";
            $post = new stdClass();

            try {
                $post->slug = trim($node->filter('button.like')->attr('data-slug'));
            } catch (\Exception $e) {}
            $post->origin = $topic;
            $post->username = trim($node->filter('.data-username')->text());

            try {
                $post->wad_cm = trim($node->filter('.info-cm-comment')->text());
            } catch (\Exception $e) {}

            $post->content = trim($node->filter('.card-body')->html());

            return $post;
        });
        echo "\r\n";

        $d = Discussion::where('title', $topic->name)->first();

        foreach ($posts as $k => $post) {
            $u = User::where('name', $post->username)->first();
        if ($u == null) {
            $u = User::create([
                'name' => $post->username,
                'display_name' => $post->username,
                'email' => rand(0, 50000000),
                'password' => '---',
                'remember_token' => '---'
            ]);
        }

        if ($u->name != 'Ognarb') {
            Post::create([
                'discussion_id' => $d->id,
                'user_id' => $u->id,
                'body' => $post->content,
            ]);
        }
        }
        //     if ($k == 0) continue;

        //     if (in_array($post->username, $upvote_users)) {
        //         foreach (Config::get('lebunker.accounts') as $account) {
        //             verify_vote(true, $post, $account);
        //         }
        //     }

        //     if (in_array($post->username, $downvote_users)) {
        //         foreach (Config::get('lebunker.accounts') as $account) {
        //             verify_vote(false, $post, $account);
        //         }
        //     }
        // }

        return $posts;
    }

    public function curl_this($url, $account)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://lebunker.net' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Authority: lebunker.net';
        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7';
        $headers[] = $account . ' ' . Config::get('lebunker.cf');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (Str::contains($result, "Just a moment...")) {
            echo "Err! So.. ";
            $this->update_cf_cookies();
            return $this->curl_this($url, $account);
        }

        if (curl_errno($ch)) {
            throw \Exception(curl_error($ch));
        }

        curl_close($ch);

        return $result;
    }

    public function update_cf_cookies()
    {
        $ch = curl_init();

        echo "Updating CF cookies.. ";

        $curl_cf_wrapper = new CFCurl(array(
            'max_retries'   => 5,                   // How many times to try and get clearance?
            'cache'         => false,               // Enable caching?
            'cache_path'    => __DIR__ . '/cache',  // Where to cache cookies? (Default: system tmp directory)
            'verbose'       => false                 // Enable verbose? (Good for debugging issues - doesn't effect cURL handle)
        ));

        curl_setopt($ch, CURLOPT_URL, 'https://lebunker.net');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

        $headers = array();
        $headers[] = 'Authority: lebunker.net';
        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36';
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
        $headers[] = 'Accept-Encoding: gzip, deflate, br';
        $headers[] = 'Accept-Language: fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = $curl_cf_wrapper->exec($ch);

        $cf_added_cookies = curl_getinfo($ch, CURLINFO_COOKIELIST);
        $cf_cookies_string = '__cfduid=' . explode("\t", $cf_added_cookies[0])[6] . '; ' . 'cf_clearance=' . explode("\t", $cf_added_cookies[1])[6] . ';';

        Config::set('lebunker.cf', $cf_cookies_string);

        echo "✔️\r\n";
        return $cf_cookies_string;
    }
}
