<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MonthlySubscription
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //  return response()->view('pages.setting.db-switcher');
        return $next($request);
        if (env('APP_ENV') === 'testing') {
            return $next($request);
        }
        if (auth()->check()) {
            return response()->view('trialover');
        }
    }
}
