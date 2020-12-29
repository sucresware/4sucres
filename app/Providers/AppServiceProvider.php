<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        Paginator::useBootstrap();
        URL::forceScheme('https');

        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));

        $version = rescue(fn () => 'v' . trim(File::get(config_path('.version'))), 'WIP', false);
        $sha = rescue(fn () => ' (' . substr(File::get(base_path('REVISION')), 0, 7) . ')', null, false);
        $env = config('app.env') == 'production' ? '' : ' - ' . config('app.env');

        Inertia::share('version', fn () => $version . $sha . $env);
        Inertia::share('execution_time', round((microtime(true) - LARAVEL_START), 3));

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
