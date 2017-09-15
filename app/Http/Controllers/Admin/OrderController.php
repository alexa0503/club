<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = \App\Order::orderBy('created_at', 'DESC');
        if($request->date1 !== null){
            $model->where('created_at', '>=', $request->date1);
        }
        if($request->date2 !== null){
            $model->where('created_at', '<', $request->date2);
        }
        if($request->status !== null){
            $model->where('status', $request->status);
        }
        if($request->username != null ){
            $uids = \App\User::where('username', 'LIKE', '%'.$request->username.'%')->get()->map(function($item){
                return $item->uid;
            })->toArray();
            $model->whereIn('uid', $uids);
        }
        $items = $model->paginate(20);
        $order_statuses = config('custom.order.statuses');
        return view('admin.order.index',[
            'items' => $items,
            'order_statuses' => $order_statuses,
        ]);
    }

    public function export(Request $request)
    {
        $model = \App\Order::orderBy('created_at', 'DESC');
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
        $orders = $model->get();
        $order_statuses = config('custom.order.statuses');
        //订单时间、订单号、产品编号、产品名、数量、总风迷币、市场价、结算价、配送相关信息（姓名、地址等）

        $arr = $orders->map(function($order) use($order_statuses){
            $code = isset($order->items[0]['product_code']) ? $order->items[0]['product_code'] : '';
            $settlement_price = isset($order->items[0]['settlement_price']) ? $order->items[0]['settlement_price'] : '';
            $price = isset($order->items[0]['price']) ? $order->items[0]['price'] : '';
            return [
                $order->number,
                $code,
                $order->items[0]['name'],
                $order->quantity,
                $order->point,
                $price,
                $settlement_price,
                $order->created_at,
                $order->receiver.'('.$order->address.')',
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
            '订单时间',
            '配送相关信息（姓名、地址等）',
            '订单状态',
        ];
        //array_unshift($arr,$arr_title);
        $contens = array_merge(array($arr_title), $arr);
        $filename = date('Ymd').'.csv';
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
        return view('admin.order.edit',[
            'order'=>$order,
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
        $order->status = 1;
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
