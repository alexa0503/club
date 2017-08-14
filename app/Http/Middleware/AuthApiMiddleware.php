<?php

namespace App\Http\Middleware;

use Closure;

class AuthApiMiddleware
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
        if( env('APP_ENV') != 'local'){
            $key = env('API_KEY');
            $signature = md5(substr($key, 0, 16).$request->timestamp);
            $timestamp = time();
            if( $request->signature != $signature){
                return response(['ret'=>1100,'msg'=>'没有足够的权限'],403);
            }
            elseif( $request->timestamp < $timestamp - 3600){
                return response(['ret'=>1101,'msg'=>'授权超时'],403);
            }
        }
        return $next($request);
    }
}
