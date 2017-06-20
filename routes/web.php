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
    return view('welcome');
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
Route::group(['middleware' => ['auth.discuz.user'],'prefix'=>'mall','namespace' => 'Mall'], function () {
    Route::get('/', function(){
        $features1 = \App\Item::where('feature1','>',0)->orderBy('feature1','ASC')->limit(4)->get();
        $features2 = \App\Item::where('feature2','>',0)->orderBy('feature2','ASC')->get();
        $page = \App\Page::find(2);
        $feature1_kvs = $page->getBlocksFromName('feature1_kv');
        $feature2_kvs = $page->getBlocksFromName('feature2_kv');
        $kvs = $page->getBlocksFromName('kv');

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
