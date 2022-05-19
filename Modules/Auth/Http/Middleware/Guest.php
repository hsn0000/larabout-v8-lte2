<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Guest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*
        * if has session logged_in
        */
        if ($request->session()->has('logged_in') && $request->session()->has('token_login'))
        {
            return redirect('/');
        }

        return $next($request);
    }
}
