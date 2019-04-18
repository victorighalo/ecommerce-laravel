<?php
/**
 * Created by PhpStorm.
 * User: itexecutive
 * Date: 17/04/2019
 * Time: 5:10 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;


class HttpsProtocol
{
    public function handle($request, Closure $next, $guard = null)
    {
        if( ! Request::secure() )
        {
        return Redirect::secure( Request::path() );
        }

        return $next($request);
    }
}