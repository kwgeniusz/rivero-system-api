<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;

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
        
        if (Session::has('locale')) {
        App::setLocale(Session::get('locale'));
        setlocale(LC_TIME, Session::get('locale'));
        }
        return $next($request);
    }
}
