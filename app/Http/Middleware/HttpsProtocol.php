<?php


namespace App\Http\Middleware;
use Closure;
use URL;

class HttpsProtocol
{
    public function handle($request, Closure $next)

    {

        if(config('app.env') === 'production') {
            URL::forceSchema('https');
        }

        return $next($request);

    }
}