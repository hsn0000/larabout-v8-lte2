<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowedDomainApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /*
        * define variable
        */
        $restriction = config('domain.api') ?? [];
        $domain = $request->getHost();

        /*
         * check domain
         */
        if(!in_array($domain,$restriction))
        {
            if ($request->ajax())
            {
                return response_api("Invalid Host.",403);
            }

            header("HTTP/1.0 403 Internal Server Error");
            exit();
        }
        return $next($request);
    }
}
