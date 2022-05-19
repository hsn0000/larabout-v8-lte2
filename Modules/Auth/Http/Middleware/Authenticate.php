<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate
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
        * if has session logged_id
        */ 
        if(!$request->session()->has("logged_in") || !$request->session()->has("token_login"))
        {
            if($request->ajax() || $request->isJson())
            {
                return response()->json(["data"=>["message"=>"You don't have permission to access this page."]],403);
            }

            return redirect(route('auth.login'));
        }

        return $next($request);
    }
}
