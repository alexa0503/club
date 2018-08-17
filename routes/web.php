<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Helpers\DiscuzHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;
use Spatie\Permission\Models\Role;
Route::get('admin/login', 'Admin\LoginController@ShowLogin');
Route::post('admin/login', 'Admin\LoginController@login');
Route::get('admin/logout', 'Admin\LoginController@logout');
Route::get('admin/install', function () {
    /*
    $user = new App\Admin();
    $user->name = 'admin';
    $user->email = 'admin@admin.com';
    $user->password = bcrypt('admin@2017');
    $user->save();
     */

    //Role::create(['guard_name'=>'admin','name' => 'superadmin']);
    //Permission::create(['guard_name'=>'admin','name' => 'global privileges']);

    $role = Role::findByName('superadmin');
    //$role->givePermissionTo('global privileges');
    //$user = App\Admin::find(1);
    //$user->givePermissionTo('global privileges');
    //$user->assignRole(['superadmin'],'superadmin');

});
Route::group(['middleware' => ['role:*', 'menu'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/dashboard', 'IndexController@index');
    Route::get('item/export', 'ItemController@export')->name('item.export');
    Route::get('item/{id}/restore', 'ItemController@restore')->name('item.restore');
    Route::resource('item', 'ItemController');
    Route::resource('page.block', 'BlockController');
    Route::get('order/export', 'OrderController@export')->name('order.export');
    Route::resource('order', 'OrderController');
    Route::get('verify/export', 'VerifyController@export');
    Route::resource('verify', 'VerifyController');
    Route::get('reference/export', 'ReferenceController@export');
    Route::resource('reference', 'ReferenceController');
    Route::get('credit/export', 'CreditController@export');
    Route::get('credit/exportdms', 'CreditController@exportdms');
    Route::get('credit/dms', 'CreditController@dms')->name('credit.dms');
    Route::resource('credit', 'CreditController');
    Route::get('members/export', 'MembersController@export');
    Route::get('members', 'MembersController@index')->name('members.index');
    Route::resource('permission', 'PermissionController');
    Route::resource('dealer', 'DealerController');
});
Route::group(['middleware' => ['auth.discuz.user']], function () {

    Route::get('/', function () {

        $agent = new Agent;
        if ($agent->isMobile()) {
            return redirect('/mall');
            //return view('mobile.index');
        }
        $page = \App\Page::find(1);
        $kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'kvs';
        })->values()->all();
        $features = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'features';
        })->values()->all();
        $hots = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'hots-default';
        })->values()->all();
        $events = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'events';
        })->values()->all();

        $right_top_kv = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'right_top_kv';
        })->values()->all();
        $right_bottom_kv = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'right_bottom_kv';
        })->values()->all();

        $forums['digest'] = \DB::table('discuz_forum_thread')
            ->join('discuz_forum_forum', 'discuz_forum_thread.fid', '=', 'discuz_forum_forum.fid')
            ->where('discuz_forum_thread.digest', 1)
            ->orderBy('discuz_forum_thread.dateline', 'DESC')
            ->select('discuz_forum_thread.*', 'discuz_forum_forum.name')
            ->offset(0)
            ->limit(10)
            ->get();

        $forums['hotreply'] = \DB::table('discuz_forum_thread')
            ->join('discuz_forum_forum', 'discuz_forum_thread.fid', '=', 'discuz_forum_forum.fid')
            ->where('discuz_forum_thread.displayorder', '0')
            ->orderBy('discuz_forum_thread.replies', 'DESC')
            ->select('discuz_forum_thread.*', 'discuz_forum_forum.name')
            ->offset(0)
            ->limit(10)
            ->get();

        $members['digest'] = \DB::table('discuz_common_member_count')
            ->join('discuz_common_member', 'discuz_common_member.uid', '=', 'discuz_common_member_count.uid')
            ->orderBy('discuz_common_member_count.digestposts', 'DESC')
            ->select('discuz_common_member_count.*', 'discuz_common_member.username')
            ->offset(0)
            ->limit(5)
            ->get();
        $members['diligent'] = \DB::table('discuz_common_member_count')
            ->join('discuz_common_member', 'discuz_common_member.uid', '=', 'discuz_common_member_count.uid')
            ->orderBy('discuz_common_member_count.posts', 'DESC')
            ->select('discuz_common_member_count.*', 'discuz_common_member.username')
            ->offset(0)
            ->limit(5)
            ->get();

        return view('index', [
            'kvs' => $kvs,
            'features' => $features,
            'hots' => $hots,
            'events' => $events,
            'right_top_kv' => $right_top_kv,
            'right_bottom_kv' => $right_bottom_kv,
            'forums' => $forums,
            'members' => $members,
        ]);
    });

    Route::get('/mall/logistics/{id}', 'MallController@logistics');
    Route::get('/mall', 'MallController@index');
    Route::get('/mall/search', 'MallController@search');
    Route::get('/mall/category/{id?}', 'MallController@category');
    Route::get('/mall/item/{id}', 'MallController@item');
    Route::get('oauthtest', function(){
        //return redirect('/oauth?'.http_build_query($array));
    });
    //app验证接口    
    Route::get('oauth', function (Request $request) {
        $timestamp =  $request->input('timestamp');
        $token = $request->input('token');
        $frame_number = $request->input('frame_number');
        $array = [
            'timestamp' => $timestamp,
            'frame_number' => $frame_number,
            'secret' => env('APP_SECRET'),
        ];
        $_token = \App\Helpers\Helper::generateToken($array);
        if($_token == null || $token !== $_token ){
            return '验证失败';
        }
        //车架号，secret匹配验证 
        $verify = \App\Verify::where('frame_number', 'LIKE', '%'.$frame_number)->first();
        if( null == $verify ){
            return '不存在该抱歉，未找到该车的实际购车记录，无法享受会员权益！赶紧购车，加入东风风光车友会吧！更多权益，等你体验！用户信息';
        }
        $user = \App\UUser::where('uid', $verify->uid)->first();
        if (null == $user) {
            return '不存在该抱歉，未找到该车的实际购车记录，无法享受会员权益！赶紧购车，加入东风风光车友会吧！更多权益，等你体验！用户信息';
        }
        $timestamp = time();
        $key = env('DISCUZ_UCKEY');
        $login_url = url('/') . '/bbs/api/uc.php?time=' . $timestamp . '&code=' . urlencode(DiscuzHelper::authcode('action=synlogin&username=' . $user->username . '&uid=' . $user->uid . '&password=' . $user->password . "&time=" . $timestamp, 'ENCODE', $key));
        return redirect($login_url);
    });
    Route::group(['middleware' => ['auth.discuz.must']], function () {
        Route::get('/profile', function () {
            $agent = new Agent;
            if (!$agent->isMobile()) {
                return redirect('/mall');
            } else {
                return view('mobile.profile');
            }
        });
        Route::get('/rule', function () {
            $agent = new Agent;
            if (!$agent->isMobile()) {
                return redirect('/mall');
            } else {
                return view('mobile.rule');
            }
        });
        Route::get('/rule/coin', function () {
            $agent = new Agent;
            if (!$agent->isMobile()) {
                return redirect('/mall');
            } else {
                return view('mobile.rule_coin');
            }
        });
        Route::get('/verify', function () {
            $uid = session('discuz.user.uid');
            $verifies = \App\Verify::where('uid', $uid)->get();
            return view('mall.verify', [
                'verifies' => $verifies,
            ]);
        });
        Route::get('/logs', function () {
            $uid = session('discuz.user.uid');
            $user = \DB::table('discuz_common_member as m')
                ->leftJoin('discuz_common_member_count as c', 'm.uid', '=', 'c.uid')
                ->select('m.username', 'c.extcredits1 as point', 'c.extcredits4 as coin')
                ->where('m.uid', $uid)
                ->first();
            $logs = \DB::table('discuz_common_credit_log as l')
                ->leftJoin('discuz_common_credit_log_field as f', 'l.logid', '=', 'f.logid')
                ->select('l.extcredits1 as point', 'l.extcredits4 as coin', 'f.title', 'f.text', 'l.dateline')
                ->orderBy('l.dateline', 'DESC')
                ->where('l.uid', $uid)
                ->get();
            return view('logs', [
                'uid' => $uid,
                'user' => $user,
                'logs' => $logs,
            ]);
        });
        //Route::get('/verify/logs', 'OwnerController@verifyLogs');
        Route::post('/verify', 'OwnerController@verify');
        Route::get('/points/update', 'OwnerController@update');
        Route::get('/reference', function () {
            return view('mall.reference');
        });
        Route::post('/reference', 'OwnerController@reference');
        //Route::post('/mall/buy', 'MallController@buy');
        Route::post('/mall/address', 'MallController@postAddress');
        //Route::post('/mall/address/default', 'MallController@defaultAddress');
        Route::get('/mall/cart', 'MallController@cart');
        Route::get('/mall/ajax/cart', 'MallController@cart');
        Route::delete('/mall/address/{id}', 'MallController@deleteAddress');
        Route::get('/mall/address/{id}', 'MallController@showAddress');
        Route::put('/mall/cart/{id}', 'MallController@updateCart');
        Route::delete('/mall/cart/{id}', 'MallController@deleteCart');
        Route::post('/mall/cart', 'MallController@add2Cart');
        Route::post('/mall/order', 'MallController@order');
        Route::get('/mall/order', 'MallController@orderIndex');
        Route::get('/mall/favourite', 'MallController@favouriteIndex');
        Route::post('/mall/favourite/{id}', 'MallController@favouritePost');
    });
});

/**********************2017-07-28*****************************/
Route::get('/openapi/userinfo', 'OpenapiController@getUserinfo');
Route::get('/openapi/extcredits1', 'OpenapiController@getExtcredits1');
Route::get('/openapi/extcredits4', 'OpenapiController@getExtcredits4');
Route::get('/openapi/credits/update', 'OpenapiController@updateCredits');
/**********************2017-07-28*****************************/

//省市数据
Route::get('/districts', function () {
    $provinces = \App\District::whereNull('parent_id')->get()->map(function ($item) {
        $cities = $item->children->map(function ($item) {
            $districts = $item->children->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name . $item->suffix,
                ];
            });
            return [
                'id' => $item->id,
                'name' => $item->name . $item->suffix,
                'districts' => $districts,
            ];
        });
        return [
            'id' => $item->id,
            'name' => $item->name . $item->suffix,
            'cities' => $cities,
        ];
    });
    return $provinces;
});
Route::post('/discuz/login', function (Request $request) {
    $password = $request->input('password');
    $username = $request->input('username');
    $user = \App\UUser::where('username', $username)->first();
    if (null == $user) {
        return ['ret' => 1001, 'msg' => '不存在的用户名'];
    }
    $timestamp = time();
    $passwordmd5 = preg_match('/^\w{32}$/', $password) ? $password : md5($password);
    if (md5($passwordmd5 . $user->salt) != $user->password) {
        return ['ret' => 1002, 'msg' => '用户名与密码不匹配'];
    }

    $key = env('DISCUZ_UCKEY');
    $login_url = url('/') . '/bbs/api/uc.php?time=' . $timestamp . '&code=' . urlencode(DiscuzHelper::authcode('action=synlogin&username=' . $user->username . '&uid=' . $user->uid . '&password=' . $user->password . "&time=" . $timestamp, 'ENCODE', $key));
    return ['ret' => 0, 'url' => $login_url, 'msg' => ''];
});
Route::get('/privacy', function () {
    return view('privacy', [
    ]);
});
Route::get('/discuz/logout', function () {
    $timestamp = time();
    $key = env('DISCUZ_UCKEY');
    $url = url('/') . '/bbs/api/uc.php?time=' . $timestamp . '&code=' . urlencode(DiscuzHelper::authcode("action=synlogout&time=" . $timestamp, 'ENCODE', $key));
    return ['ret' => 0, 'url' => $url];
});

Auth::routes();

Route::get('/login', function () {
    return redirect('/bbs/forum.php');
});
Route::post('/login', function () {

});
Route::get('/logout', function () {
    return redirect('/bbs/forum.php');
});

//Route::get('/home', 'HomeController@index')->name('home');
