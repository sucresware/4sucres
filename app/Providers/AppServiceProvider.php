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

        View::composer(['layouts/app', 'layouts/admin'], function ($view) {
            $view
                ->with('presence_counter', Cache::remember('presence_counter', now()->addMinute(), function () {
                    return User::active()->count();
                }));

            if (auth()->check()) {
                $view
                    ->with('notifications_count', user()->unreadNotifications->count())
                    ->with('private_unread_count', \App\Models\Discussion::private(user())->count() - \App\Models\Discussion::private(user())->read(user())->count())
                    ->with('body_classes', (user()->getSetting('layout.compact', false)) ? ' layout-compact' : '');
            } else {
                $view
                    ->with('body_classes', '');
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
