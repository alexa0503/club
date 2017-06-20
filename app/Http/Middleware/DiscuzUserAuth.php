<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\DiscuzHelper;
class DiscuzUserAuth
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
        $user = \App\User::where('uid',1)->first();
        \Session::put('discuz.user', $user->toArray());

        /*
        if( !isset($_COOKIE['K4Ps_2132_auth']) ){
            return redirect('/bbs/admin.php');
        }

        $auth = explode("\t", DiscuzHelper::authcode($_COOKIE['K4Ps_2132_auth'],'DECODE'));

        if( !$auth || empty($auth) ){
            return redirect('/bbs');
        }
        else{
            $user = \App\User::where('uid',$auth[1])->first();
            if( !$user ){
                return redirect('/bbs');
            }
            else{
                \Session::put('discuz.user', $user->toArray());
            }
        }
        */
        $today = strtotime(date('Y-m-d'));
        $yesterday = strtotime("-1 day",$today);
        $count = \App\Post::where('first',1)->where('dateline','>=',$today)->count();
        \Session::put('discuz.post.today_count', $count);
        $count = \App\Post::where('first',1)
            ->where('dateline','>=',$yesterday)
            ->where('dateline','<',$today)
            ->count();
        \Session::put('discuz.post.yesterday_count', $count);
        $count = \App\Post::where('first',1)->count();
        \Session::put('discuz.post.count', $count);

        $count = \App\User::count();
        \Session::put('discuz.user.count', $count);

        return $next($request);
    }
}
