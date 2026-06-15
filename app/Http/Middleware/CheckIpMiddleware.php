<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class CheckIpMiddleware
{
    public $whiteIps = [
        '205.209.115.46',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($_SERVER['HTTP_X_REAL_IP']) {
            if (!in_array($_SERVER['HTTP_X_REAL_IP'], $this->whiteIps)) {
                Storage::append('RealBlockedPublicIP_HTTP_X_REAL_IP.txt', $_SERVER['HTTP_X_REAL_IP']);

                return response()->json(['Kindly Send Email: bereanword@gmail.com']);
            }

            Storage::append('PassedIP_HTTP_X_REAL_IP.txt', $_SERVER['HTTP_X_REAL_IP']);

            return $next($request);
        } elseif ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            if (!in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $this->whiteIps)) {
                Storage::append('BlockedPublicIP_HTTP_X_FORWARDED_FOR.txt', $_SERVER['HTTP_X_FORWARDED_FOR']);

                return response()->json(['Kindly Send Email: bereanword@gmail.com']);
            }

            Storage::append('PassedIP_HTTP_X_FORWARDED_FOR.txt', $_SERVER['HTTP_X_FORWARDED_FOR']);

            return $next($request);
        }
    }
}
