<?php

namespace App\Http\Middleware;

use App\UserCount;
use Closure;
use App\Helpers\DiscuzHelper;
use Illuminate\Support\Facades\DB;
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
        $forum = DB::table('discuz_forum_forum')
            ->select('status', DB::raw('SUM(todayposts) as todayposts'),DB::raw('SUM(yesterdayposts) as yesterdayposts'),DB::raw('SUM(posts) as posts'))
            ->groupBy('status')
            ->where('status',1)
            ->first();

        \Session::put('discuz.forum.todayposts', $forum->todayposts);
        \Session::put('discuz.forum.yesterdayposts', $forum->yesterdayposts);
        \Session::put('discuz.forum.posts', $forum->posts);


        $count = \App\User::where('status',0)->count();
        \Session::put('discuz.user_count', $count);

        $user = \App\User::where('status',0)->orderBy('regdate','DESC')->first();
        \Session::put('discuz.latest_user', $user->toArray());

        return $next($request);
    }
}
