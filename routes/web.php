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

Route::group(['middleware' => ['auth.discuz.admin','menu'],'prefix'=>'admin','namespace' => 'Admin'], function () {
	Route::get('/', function () {
	   return redirect('/admin/dashboard');
   });
    Route::get('/dashboard', 'IndexController@index');
    Route::get('item/{id}/restore', 'ItemController@restore')->name('item.restore');
    Route::resource('item', 'ItemController');
    Route::resource('page.block', 'BlockController');
});
Route::group(['middleware' => ['auth.discuz.user'],'prefix'=>'mall'], function () {
    Route::get('/', function(){
        $features1 = \App\Item::where('feature1','>',0)->orderBy('feature1','ASC')->limit(4)->get();
        $features2 = \App\Item::where('feature2','>',0)->orderBy('feature2','ASC')->get();
        $page = \App\Page::find(2);
        $feature1_kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'feature1_kv';
        })->values()->all();
        $feature2_kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'feature2_kv';
        })->values()->all();

        $kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'kvs';
        })->values()->all();

        return view('mall.index',[
            'features1'=>$features1,
            'features2'=>$features2,
            'feature1_kvs'=>$feature1_kvs,
            'feature2_kvs'=>$feature2_kvs,
            'kvs'=>$kvs,
        ]);
    });
    Route::get('/item/{id}', function($id){
        $item = \App\Item::find($id);
        if( !$item ){
            return redirect('/mall');
        }
       return view('mall.item',[
           'item'=>$item,
       ]);
    });
    Route::post('/buy', 'MallController@buy');
    Route::post('/address', 'MallController@address');
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
    return ['ret'=>0,'url'=>$login_url];
});
Route::get('/t' ,function(){
    $options = [
        'frame_number'=>'11',
        'id_card'=>'23',
        'register_date'=>date('Y-m-d H:i:s'),
        'type'=>'1',
    ];
    $client = new \SoapClient("http://interface.dfsk.com.cn/infodms_interface_hy/services/HY01SOAP?wsdl");
    //var_dump(var_dump($client->__getFunctions()));
    //var_dump($client->__getTypes());
    $options = [
        'in'=>json_encode($options),
    ];
    $response = $client->__soapCall("Hy01", array($options));
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
