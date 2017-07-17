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
