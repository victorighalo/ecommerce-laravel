<?php


namespace App\Http\Middleware;
use Closure;

class HttpsProtocol
{
    public function handle($request, Closure $next)

    {

        if(config('app.env') === 'production') {
        if (!$request->secure()) {
            URL::forceSchema('https');
            }
        }


        return $next($request);

    }
}