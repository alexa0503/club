<?php

namespace App\Http\Middleware;

use Closure;

class DiscuzMustLogin
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
        if (!session('discuz.hasLogin')) {
            if($request->ajax()){
                return ['ret'=>1100,'msg'=>'必须登录'];
            }
            else{
                return redirect(url('/mall'));
            }
        }
        return $next($request);
    }
}
