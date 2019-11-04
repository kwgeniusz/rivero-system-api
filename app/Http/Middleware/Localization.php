<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Session;

class Localization
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
        
        if (Session::has('language')) {
          App::setLocale(Session::get('language'));
          setlocale(LC_TIME, Session::get('language'));
        }
        return $next($request);
    }
}
