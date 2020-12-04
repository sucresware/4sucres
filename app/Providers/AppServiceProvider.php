<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        Paginator::useBootstrap();

        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));

        $version = 'WIP';

        try {
            $version = 'v' . file_get_contents(config_path('.version'));
        } catch (\Exception $e) {
        }

        View::composer(['layouts/app', 'layouts/admin'], function ($view) use ($version) {
            $view
                ->with('version', $version)
                ->with('presence', User::online()->pluck('name')->toArray());

            if (auth()->check()) {
                $view
                    ->with('notifications_count', user()->unreadNotifications->count())
                    ->with('private_unread_count', user()->private_unread_count)
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
