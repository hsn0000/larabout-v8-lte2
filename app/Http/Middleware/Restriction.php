<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Restriction
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
        $restriction = config('restriction.whitelist');
        $ip = $request->ip();

        if($this->checkIpRange($ip))
        {
            return $next($request);
        }

        /*
        * check ip user
        */ 
        if(!in_array($ip, $restriction))
        {
            if(!$request->session()->has('passcode') && $request->session()->get('passcode') !== true)
            {
                if($request->ajax() || $request->json())
                {
                    // $data = [
                    //     'message' => 'Restricted IP request.',
                    // ];

                    // return view('layouts.blank',$data);

                    return response()->json(['data'=>['message'=>'Restricted IP request.']],403);
                }

                header("HTTP/1.0 403 Internal Server Error");
                exit();
            }

        }

        return $next($request);
    }

    /**
     * check ip in range
     *
     * @param $ip
     * @return bool
     */
    public function checkIpRange($ip)
    {
        $rangeIp = config('restriction.rangeip');
        $ip_address = $ip;

        foreach($rangeIp as $key => $val)
        {
            $min = substr($val,0,strrpos($val, ".")).'1';
            $max = substr($val,0,strrpos($val, ".")).'300';
        }

        $return = (ip2long($min) < ip2long($ip_address) && ip2long($ip_address) > ip2long($max));
        return $return;
    }
}
