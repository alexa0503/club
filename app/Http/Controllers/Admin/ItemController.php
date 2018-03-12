<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $dealers = \App\Dealer::all();
        $categories = \App\Category::all();
        $model = \App\Item::orderBy('created_at', 'DESC');
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
        $items = $model->withTrashed()->paginate(20);
        return view('admin.item.index',[
            'items' => $items,
            'dealers' => $dealers,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::all();
        $dealers = \App\Dealer::all();
        return view('admin.item.create',[
            'categories' => $categories,
            'dealers' => $dealers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\ItemPost $request)
    {
        //$request->merge(array_map('trim', $request->all()));
        $item = new \App\Item();
        $item->name = $request->name;
        $item->product_code = $request->product_code;
        $item->content = $request->input('content');
        $item->price = $request->price;
        $item->settlement_price = $request->settlement_price ? : 0;
        $item->point = $request->point;
        $item->feature1 = $request->feature1;
        $item->feature2 = $request->feature2;
        $item->subtitle = $request->subtitle;
        $item->dealer_id = $request->dealer_id;
        $item->category_id = $request->category_id;
        $item->type = $request->type;
        $item->valid_date = $request->valid_date;
        /*
        $inventories = [];
        foreach( $request->colors as $k=>$v){
            $quantity = $request->quantities[$k] ? : 0;
            $inventories[] = ['color'=>$v, 'quantity'=>$quantity];
        }
        */
        $item->inventories = [];
        $item->images = $request->images ? : [];
        $item->save();
        return response(['ret'=>0,'url'=>route('item.index')]);
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
        $categories = \App\Category::all();
        $dealers = \App\Dealer::all();
        return view('admin.item.edit',[
            'item' => \App\Item::find($id),
            'categories' => $categories,
            'dealers' => $dealers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(\App\Http\Requests\ItemPost $request, $id)
    {
        $item = \App\Item::find($id);
        $item->name = $request->name;
        $item->content = $request->input('content');
        $item->price = $request->price;
        $item->point = $request->point;
        $item->feature1 = $request->feature1;
        $item->feature2 = $request->feature2;
        $item->subtitle = $request->subtitle;
        $item->type = $request->type;
        $item->valid_date = $request->valid_date;
        $item->dealer_id = $request->dealer_id;
        $item->category_id = $request->category_id;
        $item->product_code = $request->product_code;
        $item->settlement_price = $request->settlement_price ? : 0;
        /*
        $inventories = [];
        foreach( $request->colors as $k=>$v){
            $quantity = $request->quantities[$k] ? : 0;
            $inventories[] = ['color'=>$v, 'quantity'=>$quantity];
        }
        */
        $item->inventories = [];
        $item->images = $request->images ? : [];
        $item->save();
        return response(['ret'=>0,'url'=>route('item.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = \App\Item::find($id);
        if ($item->delete()) {
            return ['ret'=>0];
        }
        else{
            return ['ret'=>1001,'msg'=>'删除失败'];
        }
    }
    public function restore($id)
    {
        \App\Item::withTrashed()->where('id',$id)->restore();
        return ['ret'=>0];
    }
}
