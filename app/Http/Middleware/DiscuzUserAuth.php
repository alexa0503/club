<?php

namespace App\Http\Middleware;

use App\UserCount;
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
        $authcode = null;
        if( isset($_COOKIE['K4Ps_2132_auth']) ){
            $key = md5('85be29aDkjYOAQgU'.$_COOKIE['K4Ps_2132_saltkey']);
            $authcode = DiscuzHelper::authcode($_COOKIE['K4Ps_2132_auth'],'DECODE',$key);
        }
        else{
            \Session::put('discuz.user', null);
            \Session::put('discuz.hasLogin',null);
        }

        if( !$authcode || empty($authcode) ){
            \Session::put('discuz.hasLogin',null);
            //return redirect('/bbs');
        }
        else{
            $auth = explode("\t", $authcode);
            $user = \App\User::where('uid',$auth[1])->first();
            if( !$user ){
                \Session::put('discuz.hasLogin',null);
                //return redirect('/bbs');
            }
            else{
                \Session::put('discuz.hasLogin',true);
                \Session::put('discuz.user', $user->toArray());
                //var_dump($user->user_group);
                \Session::put('discuz.user.user_count', $user->user_count->toArray());
                \Session::put('discuz.user.user_group', $user->user_group->toArray());
            }
        }
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

        $user = \App\User::orderBy('regdate','DESC')->first();
        \Session::put('discuz.user.latest', $user->username);


        return $next($request);
    }
}
