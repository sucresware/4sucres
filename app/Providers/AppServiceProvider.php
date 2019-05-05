<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_TIME, config('app.locale'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }
}
