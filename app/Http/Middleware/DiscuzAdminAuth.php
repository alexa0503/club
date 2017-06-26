<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\DiscuzHelper;

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
        $authcode = null;
        if( isset($_COOKIE['K4Ps_2132_auth']) ){
            $key = md5('85be29aDkjYOAQgU'.$_COOKIE['K4Ps_2132_saltkey']);
            $authcode = DiscuzHelper::authcode($_COOKIE['K4Ps_2132_auth'],'DECODE',$key);
        }
        if( !$authcode || empty($authcode) ){
            return redirect('/bbs/admin.php');
        }
        else{
            $auth = explode("\t", $authcode);
            $admin = \App\Admin::where('uid',$auth[1])->first();
            if( !$admin ){
                return redirect('/bbs/admin.php');
            }
            else{
                \Session::put('discuz.admin', $admin->toArray());
                \Session::put('discuz.admin.avatar', $admin->avatar);
            }
        }
        return $next($request);
    }
}
