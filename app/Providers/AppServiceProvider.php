<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
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
            return $view->with('presence_counter', Cache::remember('presence_counter', 3, function () {
                return User::online()->count();
            }));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    { }
}
