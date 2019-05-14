<?php

namespace App\Http\Middleware;

use Closure;

class DebugBarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && user()->can('debug mode enabled')) {
            config('app.debug', true);
            \Debugbar::enable();
        } else {
            config('app.debug', false);
            \Debugbar::disable();
        }

        return $next($request);
    }
}
