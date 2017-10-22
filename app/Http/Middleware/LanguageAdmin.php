<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;
class LanguageAdmin
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
        if (Session::has('adminapplocale') AND array_key_exists(Session::get('adminapplocale'), Config::get('languages'))) {
            App::setLocale(Session::get('adminapplocale'));
        }
        else { // This is optional as Laravel will automatically set the fallback language if there is none specified
            App::setLocale(Config::get('app.fallback_locale'));
        }
        return $next($request);
    }
}
