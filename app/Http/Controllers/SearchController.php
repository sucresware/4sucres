<?php

namespace App\Http\Controllers;

use App\Helpers\SucresHelper;
use App\Models\Discussion;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Spatie\Regex\Regex;

class SearchController extends Controller
{
    public function query()
    {
        $query = request()->input('query');
        $scope = request()->input('scope', 'posts');
        $return = view('search.results', compact('query', 'scope'));

        $categories = Category::viewables();

        SucresHelper::throttleOrFail(__METHOD__, 10, 1);

        switch ($scope) {
            case 'discussions':
                $discussions = Discussion::query()
                    ->public()
                    ->whereIn('category_id', $categories->pluck('id'))
                    ->where('title', 'like', '%' . $query . '%')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);

                $discussions
                    ->getCollection()
                    ->transform(function ($discussion) use ($query) {
                        $discussion->title = Regex::replace('/(' . $query . ')/miu', '<u>$1</u>', $discussion->title)->result();

                        return $discussion;
                    });

                return $return->with([
                    'discussions' => $discussions,
                ]);

                break;
            case 'posts':
                $posts = Post::query()
                    ->notTrashed()
                    ->where('body', 'like', '%' . $query . '%')
                    ->orderBy('created_at', 'desc')
                    ->with('discussion')
                    ->whereHas('discussion', function($q) use ($categories) {
                        return $q->where('category_id', $categories->pluck('id'));
                    })
                    ->paginate(10);

                $posts
                    ->getCollection()
                    ->transform(function ($post) use ($query) {
                        $post->body = e(implode(explode("\n", $post->body)));
                        $before = Str::before(strtolower($post->body), strtolower($query));
                        $before = strrev((new \Delight\Str\Str(strrev($before)))->truncateSafely(20));
                        $after = Str::after(strtolower($post->body), strtolower($query));
                        $after = (new \Delight\Str\Str($after))->truncateSafely(50);

                        $post->trimmed_body = $before . '<u>' . $query . '</u>' . $after;

                        return $post;
                    });

                return $return->with([
                    'posts' => $posts,
                ]);

                break;
            case 'users':
                $users = User::query()
                    ->where('name', 'like', '%' . $query . '%')
                    ->orWhere('display_name', 'like', '%' . $query . '%')
                    ->paginate(10);

                $users
                    ->getCollection()
                    ->transform(function ($user) use ($query) {
                        $user->name_for_search = Regex::replace('/(' . $query . ')/miu', '<u>$1</u>', $user->name)->result();
                        $user->display_name_for_search = Regex::replace('/(' . $query . ')/miu', '<u>$1</u>', $user->display_name)->result();

                        return $user;
                    });

                return $return->with([
                    'users' => $users,
                ]);
        }

        return $return;
    }
}
