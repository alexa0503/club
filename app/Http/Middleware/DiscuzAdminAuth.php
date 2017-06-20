<?php

namespace App\Http\Middleware;

use Closure;

class DiscuzAdminAuth
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
        $admin = \App\Admin::where('uid',1)->first();
        \Session::put('discuz.admin', $admin->toArray());

        /*
        if( !isset($_COOKIE['K4Ps_2132_auth']) ){
            return redirect('/bbs/admin.php');
        }

        $auth = explode("\t", DiscuzHelper::authcode($_COOKIE['K4Ps_2132_auth'],'DECODE'));

        if( !$auth || empty($auth) ){
            return redirect('/bbs/admin.php');
        }
        else{
            $admin = \App\Admin::where('uid',$auth[1])->first();
            if( !$admin ){
                return redirect('/bbs/admin.php');
            }
            else{
                \Session::put('discuz.admin', $admin->toArray());
            }
        }
        */

        return $next($request);
    }
}
