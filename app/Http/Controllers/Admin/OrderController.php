<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:订单管理']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $model = \App\Order::orderBy('created_at', 'DESC');
        if($admin->hasRole('管理员')){
            $dealers = \App\Dealer::all();
        }
        else{
            $role_names = $admin->getRoleNames();
            $dealers = \App\Dealer::whereIn('name', $role_names)->get();
            $dealer_ids = $dealers->map(function($item){
                return $item->id;
            });

            $item_ids = \App\Item::whereIn('dealer_id', $dealer_ids)->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }

        if($request->date1 !== null){
            $model->where('created_at', '>=', $request->date1);
        }
        if($request->date2 !== null){
            $model->where('created_at', '<', $request->date2);
        }
        if($request->status !== null){
            $model->where('status', $request->status);
        }
        if($request->name !== null){
            $item_ids = \App\Item::where('name', 'LIKE', '%'.$request->name.'%')->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        if($request->username != null ){
            $uids = \App\User::where('username', 'LIKE', '%'.$request->username.'%')->get()->map(function($item){
                return $item->uid;
            })->toArray();
            $model->whereIn('uid', $uids);
        }
        if($request->dealer_id !== null){
            $dealer = \App\Dealer::find($request->dealer_id);
            $item_ids = \App\Item::where('dealer_id', $dealer->id)->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        if($request->category_id !== null){
            $category = \App\Category::find($request->category_id);
            $item_ids = \App\Item::where('category_id', $category->id)->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        $categories = \App\Category::all();
        $items = $model->paginate(20);
        $order_statuses = config('custom.order.statuses');

        $stat['qty'] = $model->sum('quantity');
        $stat['point'] = $model->sum('point');
        //dd($stat['qty']);
        return view('admin.order.index',[
            'items' => $items,
            'order_statuses' => $order_statuses,
            'dealers' => $dealers,
            'categories' => $categories,
            'stat' => $stat
        ]);
    }

    public function export(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $model = \App\Order::orderBy('created_at', 'DESC');
        if($admin->hasRole('管理员')){
            $dealers = \App\Dealer::all();
        }
        else{
            $role_names = $admin->getRoleNames();
            $dealers = \App\Dealer::whereIn('name', $role_names)->get();
            $dealer_ids = $dealers->map(function($item){
                return $item->id;
            });

            $item_ids = \App\Item::whereIn('dealer_id', $dealer_ids)->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        if($request->date1 != null){
            $model->where('created_at', '>=', $request->date1);
        }
        if($request->date2 != null){
            $model->where('created_at', '<', $request->date2);
        }
        if($request->status != null){
            $model->where('status', $request->status);
        }
        if($request->username != null ){
            $uids = \App\User::where('username', 'LIKE', '%'.$request->username.'%')->get()->map(function($item){
                return $item->uid;
            })->toArray();
            $model->whereIn('uid', $uids);
        }
        if($request->dealer_id !== null){
            $dealer = \App\Dealer::find($request->dealer_id);
            $item_ids = \App\Item::where('dealer_id', $dealer->id)->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        if($request->category_id !== null){
            $category = \App\Category::find($request->category_id);
            $item_ids = \App\Item::where('category_id', $category->id)->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        if($request->name !== null){
            $item_ids = \App\Item::where('name', 'LIKE', '%'.$request->name.'%')->get()->map(function($item){
                return $item->id;
            });
            $ids = \App\OrderItem::whereIn('item_id', $item_ids)->get()->map(function($item){
                return $item->order_id;
            });
            $model->whereIn('id', $ids);
        }
        $stat['qty'] = $model->sum('quantity');
        $stat['point'] = $model->sum('point');
        $orders = $model->get();
        $order_statuses = config('custom.order.statuses');
        //订单时间、订单号、产品编号、产品名、数量、总风迷币、市场价、结算价、配送相关信息（姓名、地址等）

        $arr = $orders->map(function($order) use($order_statuses){
            $code = isset($order->items[0]['product_code']) ? $order->items[0]['product_code'] : '';
            $settlement_price = isset($order->items[0]['settlement_price']) ? $order->items[0]['settlement_price'] : '';
            $price = isset($order->items[0]['price']) ? $order->items[0]['price'] : '';
            $dealer = '';
            $order_items = \App\OrderItem::with(['item'=>function($query){
                $query->withTrashed();
            }])->where('order_id', $order->id)->get();
            foreach( $order_items as $order_item ){
                $dealer = (null == $order_item->item || null == $order_item->item->dealer) ? '' : $order_item->item->dealer->name;
                break;
            }
            return [
                '="'.$order->number.'"',
                $code,
                $order->items[0]['name'],
                $order->quantity,
                $order->point,
                $price,
                $settlement_price,
                $dealer,
                $order->logistics_name.' '.$order->logistics_code,
                $order->created_at,
                $order->receiver.'，手机：'.$order->mobile.'，地址：'.$order->address,
                $order_statuses[$order->status],
            ];
        })->toArray();
        $arr_title = [
            '订单号',
            '产品编号',
            '产品名',
            '数量',
            '总风迷币',
            '市场价',
            '结算价',
            '经销商',
            '快递信息',
            '订单时间',
            '配送相关信息（姓名、手机、地址等）',
            '订单状态',
        ];
        $arr_footer = [
            '总计',
            '',
            '',
            $stat['qty'],
            $stat['point'],
            '',
            '',
            '',
            '',
            '',
            ''
        ];
        
        //array_unshift($arr,$arr_title);
        $contens = array_merge(array($arr_title), $arr,  array($arr_footer));
        $filename = 'orders/'.date('Ymd').rand(1000,9999).'.csv';
        $file = fopen(public_path($filename), 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        foreach ($contens as $content) {
            fputcsv($file, $content);
        }
        fclose($file);
        return redirect(asset($filename));

        //return $arr;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = \App\Order::find($id);
        $json_string = '[
            {
                "com":"顺丰",
                "no":"sf"
            },
            {
                "com":"申通",
                "no":"sto"
            },
            {
                "com":"圆通",
                "no":"yt"
            },
            {
                "com":"韵达",
                "no":"yd"
            },
            {
                "com":"天天",
                "no":"tt"
            },
            {
                "com":"EMS",
                "no":"ems"
            },
            {
                "com":"中通",
                "no":"zto"
            },
            {
                "com":"汇通",
                "no":"ht"
            },
            {
                "com":"全峰",
                "no":"qf"
            },
            {
                "com":"德邦",
                "no":"db"
            },
            {
                "com":"国通",
                "no":"gt"
            },
            {
                "com":"如风达",
                "no":"rfd"
            },
            {
                "com":"京东快递",
                "no":"jd"
            },
            {
                "com":"宅急送",
                "no":"zjs"
            },
            {
                "com":"EMS国际",
                "no":"emsg"
            },
            {
                "com":"Fedex国际",
                "no":"fedex"
            },
            {
                "com":"邮政国内（挂号信）",
                "no":"yzgn"
            },
            {
                "com":"邮政",
                "no":"yzgn"
            },
            {
                "com":"UPS国际快递",
                "no":"ups"
            },
            {
                "com":"中铁快运",
                "no":"ztky"
            },
            {
                "com":"佳吉快运",
                "no":"jiaji"
            },
            {
                "com":"速尔快递",
                "no":"suer"
            },
            {
                "com":"信丰物流",
                "no":"xfwl"
            },
            {
                "com":"优速快递",
                "no":"yousu"
            },
            {
                "com":"中邮物流",
                "no":"zhongyou"
            },
            {
                "com":"天地华宇",
                "no":"tdhy"
            },
            {
                "com":"安信达快递",
                "no":"axd"
            },
            {
                "com":"快捷速递",
                "no":"kuaijie"
            },
            {
                "com":"马来西亚（大包EMS）",
                "no":"malaysiaems"
            },
            {
                "com":"马来西亚邮政（小包）",
                "no":"malaysiapost"
            }
        ]';
        $list = json_decode($json_string);

        $logistics_no = null;
        $logistics = null;
        
        foreach($list as $v){
            if( preg_match('/'.$v->com.'/i', $order->logistics_name)){
                $logistics_no = $v->no;
                break;
            }
        }
        if( null == $logistics_no) {
            $logistics = null;
            //return response()->json(['ret'=>1002,'errMsg'=>'没有物流信息']);
        }
        if( !empty($order->logistics_code) && $order->status == 1 ){
            $url = 'http://v.juhe.cn/exp/index?key=9f904834e0de2fa8a780ae99542e802f&com='.$logistics_no.'&no='.$order->logistics_code.'&dtype=json';
            $reponse = json_decode(file_get_contents($url),true);
            if($reponse['error_code'] == 0){
                $logistics = $reponse['result']['list'];
            }
        }
        return view('admin.order.edit',[
            'order'=>$order,
            'logistics' => $logistics,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'logistics_name.*' => '请输入物流名称~',
            'logistics_code.*' => '请输入物流编号~'
        ];
        $validator = \Validator::make($request->all(), [
            'logistics_name' => 'required',
            'logistics_code' => 'required',
        ], $messages);
        $validator->after(function ($validator) use ($request) {
            if( $request->color ){
                $item = \App\Item::find($request->item_id);
                $inventory = \App\Helpers\Helper::getInventory($item->inventories, $request->color);
                if ( $inventory < $request->quantity ) {
                    $validator->errors()->add('quantity', '商品库存不足');
                }
            }

        });
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }
        $order = \App\Order::find($id);
        $order->logistics_name = $request->logistics_name;
        $order->logistics_code = $request->logistics_code;
        if( $request->next_step != 1 && $order->status == 1){
            $order->status = 1;
        }
        else{
            $order->status += 1;
        }
        
        $order->save();
        return response(['ret'=>0,'url'=>route('order.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
