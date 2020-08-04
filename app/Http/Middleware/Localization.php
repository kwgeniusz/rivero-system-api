<?php

namespace App\Http\Middleware;

use App;
use Auth;
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
    //si en la variable global session existe un indice llamado language
    //ejecuta una asignacion de ese language a Locale en config laravel
    //nota:session::has('language') viene de lo que el usuario escoge en el  menu el idioma eso pasa a la route y luego alli se asigna ese valor a session
        if (Session::has('language')) {
           //para cambiar el lenguaje en config: laravel
             App::setLocale(Session::get('language'));
        }
    //si variable Auth de laravel esta llena ejecuta todo este codigo
        //esto es para que funcione en la ventana de login
      if(Auth::user() != null) { 
         if(!session()->has('countryId') || !session()->has('companyId')) { 
             session(['countryId' => Auth::user()->countryId, 
                      'countryName' => Auth::user()->country->countryName,
                      'countryLanguage' => Auth::user()->country->countryConfiguration->language
                    ]); 
              session(['companyId' => Auth::user()->companyId,
                       'companyName' => Auth::user()->company->companyName
                      ]);
          }
         } 
        return $next($request);
    }
}
