<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use App\Helpers\DiscuzHelper;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Validator;

class MallController extends Controller
{
    //首页
    public function index()
    {
        $agent = new Agent;
        $limit = $agent->isMobile() ? 6 : 6;
        $features1 = \App\Item::where('feature1', '>', 0)->orderBy('feature1', 'ASC')->limit($limit)->get();
        $categories = \App\Category::orderBy('sort_id', 'ASC')->get();
        $page = \App\Page::find(2);
        $kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'kvs';
        })->values()->all();
        $latest = \App\Item::orderBy('created_at', 'DESC')->limit($limit)->get();
        if( session('discuz.hasLogin') ){
            $discuz_user = session('discuz.user');
            $point = $discuz_user['user_count']['extcredits4'];
            $features2 =  \App\Item::where('point', '<', $point)->limit($limit)->get();
        }
        else{
            $features2 = [];
        }
        $features3 =  \App\Item::orderBy('feature2', 'ASC')->orderBy('sold_quantity', 'DESC')->limit($limit)->get();
        
        if($agent->isMobile()){
            $blade = 'mall.mobile.index';
        }
        else{
            $blade = 'mall.index';
        }
        return view($blade, [
            'features1' => $features1,
            'features2' => $features2,
            'features3' => $features3,
            'latest' => $latest,
            'categories' => $categories,
            'kvs' => $kvs,
        ]);
    }
    public function search(Request $request)
    {
        $agent = new Agent;
        $category_id = $request->input('cat_id');
        $name = $request->input('keywords');
        $order_name = strtolower($request->input('order_name'));
        $order_type = strtoupper($request->input('order_type'));
        $point_min = (int)$request->input('point_min');
        $point_max = (int)$request->input('point_max');
        if( $order_name != 'created_at' && $order_name != 'name' && $order_name != 'point' ){
            $order_name = 'created_at';
        }
        $order_type = $order_type != 'DESC' ? 'ASC' : 'DESC';
        $model = \App\Item::orderBy($order_name, $order_type);
        if( $category_id != null ){
            $model->where('category_id',$category_id);
            $category = \App\Category::find($category_id);
        }
        else{
            $category = null;
        }
        if( null != $name ){
            $model->where('name', 'LIKE', '%'.$name.'%');
        }
        if( $point_min > 0){
            $model->where('point', '>' ,$point_min);
        }
        if( $point_max > 0){
            $model->where('point', '<' ,$point_max);
        }
        $items = $model->paginate(18);
        $page = \App\Page::find(2);

        $kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'kvs';
        })->values()->all();

        $categories = \App\Category::all();

        if($agent->isMobile()){
            $blade = 'mall.mobile.search';
        }
        else{
            $blade = 'mall.search';
        }
        return view($blade, [
            'items' => $items,
            'category'=>$category,
            'categories'=>$categories,
            'kvs' => $kvs,
        ]);
    }
    //产品分类页面
    public function category($category_id = null)
    {
        if( $category_id == null ){
            $items = \App\Item::where('feature1', '>', 0)->orderBy('feature1', 'ASC')->paginate(18);
            $category = null;
        }
        else{
            $items = \App\Item::where('category_id',$category_id)->paginate(18);
            $category = \App\Category::find($category_id);
        }
        $page = \App\Page::find(2);

        $kvs = $page->blocks->filter(function ($value, $key) {
            return $value->name == 'kvs';
        })->values()->all();
        $categories = \App\Category::all();
        return view('mall.category', [
            'items' => $items,
            'category'=>$category,
            'categories'=>$categories,
            'kvs' => $kvs,
        ]);
    }

    //商品详情页面
    public function item($id)
    {
        $item = \App\Item::find($id);
        if (!$item) {
            return redirect('/mall');
        }

        return view('mall.item', [
            'item' => $item,
        ]);
    }

    //订单提交处理
    public function order(Request $request)
    {
        if( null == $request->input('address_id')){
            return ['ret' => 1005, 'msg' => '必须选择一个收货地址'];
        }
        elseif( null == $request->input('id')){
            return ['ret' => 1006, 'msg' => '请选择一个商品'];
        }
        $uid = session('discuz.user.uid');
        $user_count = DB::table('discuz_common_member_count')->where('uid',$uid)->first();

        $carts = \App\Cart::where('uid', $uid)->whereIn('id',$request->input('id'))->get();
        if(count($carts) <= 0){
            return ['ret' => 1004, 'msg' => '抱歉，您的购物车没有商品哦'];
        }
        $amount_quantity = 0;
        $amount_point = 0;
        $items = [];
        $has_coupon = false;
        foreach($carts as $k=>$cart){
            $amount_quantity += $cart->quantity;
            $amount_point += ($cart->item->point * $cart->quantity);
            $_item = [
                'name'=>$cart->item->name,
                'product_code'=>$cart->item->product_code,
                'price'=>$cart->item->price,
                'settlement_price'=>$cart->item->settlement_price,
                'quantity'=>$cart->quantity,
                'image'=>$cart->item->images[0],
                'point'=>$cart->item->point,
                'type'=>$cart->item->type,
            ];
            //优惠券
            if($cart->item->type == 1){
                $has_coupon = true;
                $code = [];
                for ($i=0; $i<$cart->quantity ;$i++){

                    $coupon = new \App\Coupon();
                    $coupon->uid = $uid;
                    $coupon->valid_date = $cart->item->valid_date;
                    $code[] = $coupon->code = \App\Helpers\Helper::generateCouponCode();
                    $coupon->save();
                }
                $_item['code'] = implode($code,',');
            }
            $items[$k] = $_item;
        }
        if ($user_count->extcredits4 < $amount_point || $amount_point <= 0) {
            return ['ret' => 1001, 'msg' => '抱歉，您的积分不够'];
        }
        $address = \App\DeliveryAddress::find($request->input('address_id'));

        DB::beginTransaction();
        try {
            foreach($carts as $k=>$cart){
                $order = new \App\Order();
                $order->uid = $uid;
                $order->quantity = $cart->quantity;
                $order->point = $cart->item->point * $cart->quantity;
                $order->items = array($items[$k]);
                $order->receiver = $address->name;
                $order->mobile = $address->mobile;
                $order->telephone = $address->telephone;
                $order->status = $cart->item->type == 1 ? 2 : 0;//如果是优惠券直接完成状态
                $order->address = $address->province.$address->city.$address->district.$address->detail;
                $order->save();

                $item_name = [];
                $item_name[] = $cart->item->name;
                $order_item = new \App\OrderItem();
                $order_item->item_id = $cart->item_id;
                $order_item->quantity = $cart->quantity;
                $order_item->point = $cart->item->point;
                $order_item->code = $cart->item->type == 1 ? $items[$k]['code'] : NULL;
                $order_item->order_id = $order->id;
                $order_item->save();
                $item = \App\Item::find($cart->item_id);
                $item->sold_quantity += $cart->quantity;//已售
                $item->save();
                //删除购物车
                $cart->delete();
                DB::commit();
            }
        } catch (\Exception $e) {
            return ['ret' => 1200, 'msg' => $e->getMessage()];
            DB::rollback();
        }



        DB::table('discuz_common_member_count')->where('uid',$uid)->update([
            'extcredits4' => $user_count->extcredits4 - $amount_point,
        ]);
        //订单提交
        $logid = DB::table('discuz_common_credit_log')->insertGetId([
            'uid' => $uid,
            'operation' => '',
            'relatedid' => $uid,
            'dateline' => time(),
            'extcredits1' => 0,
            'extcredits4' => $amount_point * -1,
            'extcredits2' => 0,
            'extcredits3' => 0,
            'extcredits5' => 0,
            'extcredits6' => 0,
            'extcredits7' => 0,
            'extcredits8' => 0,
        ]);
        DB::table('discuz_common_credit_log_field')->insert([
            'logid' => $logid,
            'title' => '商城购买',
            'text' => '购买商品消耗风迷币',
        ]);

        if( env('APP_ENV') != 'local'){
            $timestamp = time();
            $key = env('DISCUZ_UCKEY');
            $fromuid = 1;
            $msgto = $uid;
            $subject = '购买商品成功';
            $message = '您于成功购买了' . $amount_quantity . '件' . implode(',', $item_name) . '，您的收货地址是：' . $address->detail . '，联系电话为：' . $address->mobile . '。我们于7个工作日内发货，请查收。';
            $url = url('/') . '/bbs/api/uc.php?time=' . $timestamp . '&code=' . urlencode(DiscuzHelper::authcode("action=sendpm&fromuid=" . $fromuid . "&msgto=" . $msgto . "&subject=" . $subject . "&message=" . $message . "&time=" . $timestamp, 'ENCODE', $key));
            $client = new \GuzzleHttp\Client();
            $client->request('GET', $url);
        }

        $msg = $has_coupon ? '订单提交成功，请在我的订单中查看券码！' : '订单提交成功，将尽快安排物流配送！';
        return ['ret' => 0, 'msg' => $msg];
        //
    }
    //购物车相关功能
    public function cart(Request $request)
    {
        $uid = session('discuz.user.uid');
        $carts = \App\Cart::where('uid', $uid)->with(['item'=>function($query){
            //$query->whereNull('deleted_at');
            $query->withTrashed();
        }])->get()->where('item.deleted_at',null);

        $addresses = \App\DeliveryAddress::where('uid', $uid)->get();
        if($request->ajax()){
            return ['ret'=>0,'data'=>$carts];
        }
        else{
            return view('mall.cart', [
                'carts' => $carts,
                'addresses' => $addresses,
            ]);
        }

    }
    public function deleteCart(Request $request,$id)
    {
        $cart = \App\Cart::find($id);
        if($cart->uid != session('discuz.user.uid')){
            return ['ret'=>1001,'msg'=>'无权删除'];
        }
        if($cart->delete()){
            return ['ret'=>0];
        }
        else{
            return ['ret'=>1002,'msg'=>'删除失败'];
        }

    }

    public function add2Cart(Request $request)
    {
        $messages = [
            'quantity.required' => '请选择数量',
            'quantity.numeric' => '商品数量必须为整数',
            'quantity.min' => '商品数量不能小于:min',
            'quantity.max' => '商品数量不能大于:max',
            'item_id.*' => '商品必须存在哦~',
        ];
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:100',
            'item_id' => 'required|exists:items,id',
        ], $messages);

        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }
        $uid = session('discuz.user.uid');
        $cart = \App\Cart::where('uid', $uid)
            ->where('item_id', $request->item_id)
            ->first();
        if( $cart == null ){
            $cart = new \App\Cart;
            $cart->quantity = $request->quantity;
        }
        else{
            $cart->quantity = $request->quantity + $cart->quantity;
        }
        $cart->item_id = $request->item_id;
        $cart->uid = $uid;
        $cart->save();
        return ['ret' => 0, 'msg'=>'已放入购物车，您可以继续浏览其他页面'];
    }
    public function updateCart(Request $request,$id)
    {
        $quantity = (int)$request->quantity > 0 ? $request->quantity : 1;
        $cart = \App\Cart::find($id);
        if( $cart->uid != session('discuz.user.uid')){
            return ['ret'=>1002,'msg'=>'无权限'];
        }
        $cart->quantity = $quantity;
        $cart->save();
        return ['ret'=>0,'msg'=>''];
    }
    //收货地址
    public function deleteAddress(Request $request,$id){

        $address = \App\DeliveryAddress::find($id);
        if($address->uid != session('discuz.user.uid') ){
            return ['ret' => 1101, 'msg'=>'您没有权限'];
        }
        if ($address->delete()) {
            return ['ret'=>0];
        }
        else{
            return ['ret'=>1001,'msg'=>'删除失败'];
        }
    }
    public function showAddress(Request $request,$id)
    {

        $address = \App\DeliveryAddress::find($id);
        if($address->uid != session('discuz.user.uid') ){
            return ['ret' => 1101, 'msg'=>'您没有权限'];
        }
        return ['ret'=>0, 'data'=>$address];
    }
    public function postAddress(\App\Http\Requests\AddressPost $request)
    {
        $uid = session('discuz.user.uid');
        $data = [
            'uid' => $uid,
            'area' => '',
            'name' => $request->input('name'),
            'detail' => $request->input('detail'),
            'mobile' => $request->input('mobile'),
            'telephone' => $request->input('telephone'),
            'province' => $request->input('province'),
            'city' => $request->input('city'),
            'district' => $request->input('district'),
            'email' => '',
            'alias' => 'default',
        ];
        if( null == $request->input('id')){
            \App\DeliveryAddress::firstOrCreate($data);
        }
        else{
            \App\DeliveryAddress::where('id', $request->input('id'))->update($data);
        }

        return ['ret' => 0, 'msg' => '操作成功'];
    }
    //订单页面
    public function orderIndex()
    {
        $uid = session('discuz.user.uid');
        $orders = \App\Order::where('uid', $uid)->orderBy('created_at','DESC')->get()->map(function($order){
            $_items = [];
            foreach($order->items as $item){
                if(isset($item['type']) && $item['type'] == 1 && isset($item['code'])){
                    $code = explode(',', $item['code']);
                    $coupon = \App\Coupon::whereIn('code', $code)->get()->toArray();
                    $item['coupon'] = $coupon;
                }
                $_items[] = $item;
            }
            $order->items = $_items;
            return $order;
        });

        $order_statuses = config('custom.order.statuses');
        return view('mall.order',[
            'orders'=>$orders,
            'order_statuses' => $order_statuses,
        ]);
    }
}
