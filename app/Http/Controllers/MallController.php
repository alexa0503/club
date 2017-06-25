<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DiscuzHelper;

class MallController extends Controller
{
    //
    public function index()
    {
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
    }
    public function item($id){
        $item = \App\Item::find($id);
        if( !$item ){
            return redirect('/mall');
        }
        return view('mall.item',[
            'item'=>$item,
        ]);
    }
    public function buy(\App\Http\Requests\OrderPost $request)
    {
        if( !\Session::get('discuz.user') || !\Session::get('discuz.user.uid')){
            return ['ret'=>1100,'msg'=>'未登录'];
        }
        $uid = \Session::get('discuz.user.uid');
        $user_count = \App\UserCount::where('uid', $uid)->first();
        $item = \App\Item::find($request->item_id);
        $amount = $item->point*$request->quantity;
        if($user_count->point < $amount){
            return ['ret'=>1001,'msg'=>'抱歉，您的积分不够'];
        }
        return ['ret'=>0];

    }
    public function address(\App\Http\Requests\AddressPost $request)
    {
        if( !\Session::get('discuz.user') || !\Session::get('discuz.user.uid')){
            return ['ret'=>1100,'msg'=>'未登录'];
        }

        $uid = \Session::get('discuz.user.uid');
        $user_count = \App\UserCount::where('uid', $uid)->first();
        $item = \App\Item::find($request->item_id);
        $amount = $item->point*$request->quantity;
        if($user_count->point < $amount){
            return ['ret'=>1001,'抱歉，您的积分不够'];
        }

        //收货地址添加
        $address = \App\DeliveryAddress::where('uid', $uid)->first();
        if( null == $address ){
            $address = new \App\DeliveryAddress;
            $address->uid = $uid;
        }
        $address->area = '';
        $address->name = $request->input('name');
        $address->detail = $request->input('detail');
        $address->mobile = $request->input('mobile');
        $address->telephone = $request->input('telephone');
        $address->email = '';
        $address->alias = 'default';
        $address->save();


        $color = $item->inventories[$request->inventory]['color'];
        $order = new \App\Order;
        $order->uid = $uid;
        $order->item_id = $request->item_id;
        $order->color = $color;
        $order->quantity = $request->quantity;
        $order->point = $item->point;
        $order->save();

        \App\UserCount::where('uid', $uid)->update(
            ['extcredits4'=>$user_count->point - $amount]
        );
        //订单提交


        $timestamp = time();
        $key = env('DISCUZ_UCKEY');
        $fromuid = 1;
        $msgto = \Session::get('discuz.user.uid');
        $subject = '购买商品成功';
        $message = '您于成功购买了'.$request->quantity.'件'.$item->name.'，您的收货地址是：'.$address->detail.'，联系电话为：'.$address->mobile.'。我们于7个工作日内发货，请查收。';
        $url = 'http://club.himyweb.com//bbs/api/uc.php?time='.$timestamp.'&code='.urlencode(DiscuzHelper::authcode("action=sendpm&fromuid=".$fromuid."&msgto=".$msgto."&subject=".$subject."&message=".$message."&time=".$timestamp, 'ENCODE', $key));
        $client = new \GuzzleHttp\Client();
        $client->request('GET', $url);
        return ['ret'=>0,'msg'=>'恭喜您，购买成功'];
    }
}
