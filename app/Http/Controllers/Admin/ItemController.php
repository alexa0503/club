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
    public function index()
    {
        $items = \App\Item::withTrashed()->paginate(20);
        return view('admin.item.index',[
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(\App\Http\Requests\ItemPost $request)
    {
        $item = new \App\Item();
        $item->name = $request->name;
        $item->content = $request->input('content');
        $item->price = $request->price;
        $item->point = $request->point;
        $item->feature1 = $request->feature1;
        $item->feature2 = $request->feature2;
        $item->subtitle = $request->subtitle;
        $inventories = [];
        foreach( $request->colors as $k=>$v){
            $quantity = $request->quantities[$k] ? : 0;
            $inventories[] = ['color'=>$v, 'quantity'=>$quantity];
        }
        $item->inventories = $inventories;
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
        return view('admin.item.edit',[
            'item' => \App\Item::find($id),
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
        $inventories = [];
        foreach( $request->colors as $k=>$v){
            $quantity = $request->quantities[$k] ? : 0;
            $inventories[] = ['color'=>$v, 'quantity'=>$quantity];
        }
        $item->inventories = $inventories;
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
