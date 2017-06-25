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

Route::group(['middleware' => ['auth.discuz.admin','menu'],'prefix'=>'admin','namespace' => 'Admin'], function () {
	Route::get('/', function () {
	   return redirect('/admin/dashboard');
   });
    Route::get('/dashboard', 'IndexController@index');
    Route::get('item/{id}/restore', 'ItemController@restore')->name('item.restore');
    Route::resource('item', 'ItemController');
    Route::resource('page.block', 'BlockController');
});
Route::group(['middleware' => ['auth.discuz.user']], function () {

    Route::get('/', function () {
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

        return view('index',[
            'kvs'=>$kvs,
            'features'=>$features,
            'hots'=>$hots,
            'events'=>$events,
            'right_top_kv'=>$right_top_kv,
            'right_bottom_kv'=>$right_bottom_kv,
        ]);
    });

    Route::get('/mall', 'MallController@index');
    Route::get('/mall/item/{id}', 'MallController@item');
    Route::post('/mall/buy', 'MallController@buy');
    Route::post('/mall/address', 'MallController@address');
});
use App\Helpers\DiscuzHelper;
use Illuminate\Http\Request;
Route::post('/discuz/login', function(Request $request){
    $password = $request->input('password');
    $username = $request->input('username');
    $user = \App\UUser::where('username',$username)->first();
    if( null == $user ){
        return ['ret'=>1001,'msg'=>'不存在的用户名'];
    }
    $timestamp = time();
    $passwordmd5 = preg_match('/^\w{32}$/', $password) ? $password : md5($password);
    if( md5($passwordmd5.$user->salt) != $user->password ){
        return ['ret'=>1002,'msg'=>'用户名与密码不匹配'];
    }

    $key = env('DISCUZ_UCKEY');
    $login_url = url('/').'/bbs/api/uc.php?time='.$timestamp.'&code='.urlencode(DiscuzHelper::authcode('action=synlogin&username='.$user->username.'&uid='.$user->uid.'&password='.$user->password."&time=".$timestamp, 'ENCODE', $key));
    return ['ret'=>0,'url'=>$login_url,'msg'=>''];
});
Route::get('/discuz/logout', function(){
    $timestamp = time();
    $key = env('DISCUZ_UCKEY');
    $url = url('/').'/bbs/api/uc.php?time='.$timestamp.'&code='.urlencode(DiscuzHelper::authcode("action=synlogout&time=".$timestamp, 'ENCODE', $key));
    return ['ret'=>0,'url'=>$url];
});
Route::get('/discuz/verify' ,function(Request $request){
    $options = [
        'frame_number'=>$request->input('frame_number'),
        'id_card'=>$request->input('id_card'),
        'register_date'=>date('Y-m-d H:i:s'),
        'type'=>'1',
    ];
    $client = new \SoapClient("http://interface.dfsk.com.cn/infodms_interface_hy/services/HY01SOAP?wsdl");
    $options = [
        'in'=>json_encode($options),
    ];
    $response = $client->__soapCall("Hy01", array($options));
	$result = json_decode($response->out,true);
	if($result['ret'] == 0){
		//增加积分
	}
	return $result;
});
Route::get('/discuz/points/{id}', function(Request $request, $id){
	$options = [
        'frame_number'=>$request->input('frame_number'),
        'id_card'=>$request->input('id_card'),
    ];
	$client = new \SoapClient("http://interface.dfsk.com.cn/infodms_interface_hy/services/HY02SOAP?wsdl");
    $options = [
        'in'=>json_encode($options),
    ];
    $response = $client->__soapCall("Hy02", array($options));
	$result = json_decode($response->out,true);
	if($result['ret'] == 0){
		//增加积分
	}
	return $result;
});

Auth::routes();

Route::get('/login', function(){
	return redirect('/bbs/forum.php');
});
Route::post('/login', function(){

});
Route::get('/logout', function(){
	return redirect('/bbs/forum.php');
});

//Route::get('/home', 'HomeController@index')->name('home');
