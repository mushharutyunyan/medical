<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'admin')
    {
        if(Auth::guard($guard)->user()->role->name != 'admin' && Auth::guard($guard)->user()->role->id != 1){
            return redirect('admin/404');
        }
        return $next($request);
    }
}
