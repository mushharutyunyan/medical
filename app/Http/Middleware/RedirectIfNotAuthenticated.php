<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\UserOrder;
use App\Models\UserOrderMessage;
class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}

