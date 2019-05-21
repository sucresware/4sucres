<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));

        View::composer('*', function ($view) {
            // $view
            //     ->with('presence_counter', Cache::remember('presence_counter', 3, function () {
            //         return User::online()->count();
            //     }));

            if (auth()->check()) {
                $view
                    ->with('notifications_count', Cache::remember('notifications_count_' . user()->id, 1, function () {
                        return user()->unreadNotifications->count();
                    }))
                    ->with('private_unread_count', Cache::remember('private_unread_count_' . user()->id, 1, function () {
                        return \App\Models\Discussion::private(user())->count() - \App\Models\Discussion::private(user())->read(user())->count();
                    }));
            }

            return $view;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
