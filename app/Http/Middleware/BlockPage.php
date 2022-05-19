<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $module,$role)
    {
        if ( ! module_access($module,$role))
        {
            if ($request->ajax() || $request->isJson())
            {
                return response_api("You don't have permission to access this page.",403);
            }

            header("HTTP/1.0 403 You don't have permission to access this page.");
            exit();
        }

        return $next($request);
    }
}
