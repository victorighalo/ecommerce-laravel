<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
class AppSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

//        if($request->path() == 'login' ||
//            $request->path() == 'logout' ||
//            $request->path() == 'register' ||
//            $request->path() == 'office/*' ||
//            $request->path() == 'office/*/*'
//        ){
//            return $next($request);
//        }else{
//            dd('Stop');
//        }
        if($request->method() == 'POST'){
            return $next($request);
        }
        if ($request->path() != 'install') {
            $app_settings = DB::table('app_settings')->count();
            if (!$app_settings) {
                return response()->redirectToRoute('install');
            }
            return $next($request);
        }
        if ($request->path() == 'install') {
            $app_settings = DB::table('app_settings')->count();
            if ($app_settings) {
                return response()->redirectToRoute('/');
            }
            return $next($request);
        }

        return $next($request);
    }
}
