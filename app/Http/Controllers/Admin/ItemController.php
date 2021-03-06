<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:产品管理']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $categories = \App\Category::all();
        $model = \App\Item::orderBy('created_at', 'DESC');
        
        if($admin->hasRole('管理员')){
            $dealers = \App\Dealer::all();
        }
        else{
            $role_names = $admin->getRoleNames();
            $dealers = \App\Dealer::whereIn('name', $role_names)->get();
            $dealer_ids = $dealers->map(function($item){
                return $item->id;
            });
            $model->whereIn('dealer_id',$dealer_ids);
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
        
        if($request->input('name') != null){
            $model->where('name', 'LIKE', '%'.$request->name.'%');
        }
        if($request->dealer_id !== null){
            $model->where('dealer_id', $request->dealer_id);
        }
        if($request->category_id !== null){
            $model->where('category_id', $request->category_id);
        }
        $items = $model->withTrashed()->paginate(20);
        return view('admin.item.index',[
            'items' => $items,
            'dealers' => $dealers,
            'categories' => $categories,
        ]);
    }

    public function export(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $categories = \App\Category::all();
        $model = \App\Item::orderBy('created_at', 'DESC');
        
        if($admin->hasRole('管理员')){
            $dealers = \App\Dealer::all();
        }
        else{
            $role_names = $admin->getRoleNames();
            $dealers = \App\Dealer::whereIn('name', $role_names)->get();
            $dealer_ids = $dealers->map(function($item){
                return $item->id;
            });
            $model->whereIn('dealer_id',$dealer_ids);
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
        
        if($request->input('name') != null){
            $model->where('name', 'LIKE', '%'.$request->name.'%');
        }
        if($request->dealer_id !== null){
            $model->where('dealer_id', $request->dealer_id);
        }
        if($request->category_id !== null){
            $model->where('category_id', $request->category_id);
        }
        
        $items = $model->withTrashed()->get()->map(function($item){
            return [
                $item->product_code,
                $item->name,
                $item->type==1?'优惠券':'普通商品',
                $item->category ? $item->category->name : '--',
                $item->dealer ? $item->dealer->name : '--',
                $item->sold_quantity,
                $item->price,
                $item->point,
                $item->deleted_at ? '已删' : '正常'
            ];
        })->toArray();
        $arr_title = [
            '产品编号',
            '产品名',
            '产品性质',
            '产品分类',
            '经销商',
            '已售',
            '市场价',
            '风迷币',
            '状态'
        ];
        
        //array_unshift($arr,$arr_title);
        $contens = array_merge(array($arr_title), $items);
        $filename = 'downloads/datacsv/item-'.date('Ymd').rand(1000,9999).'.csv';
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
        $admin = Auth::guard('admin')->user();
        $categories = \App\Category::all();
        if($admin->hasRole('管理员')){
            $dealers = \App\Dealer::all();
        }
        else{
            $role_names = $admin->getRoleNames();
            $dealers = \App\Dealer::whereIn('name', $role_names)->get();
        }
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
        $item->coupon_value = $request->coupon_value ? : 0;
        $item->settlement_price = $request->settlement_price ? : 0;
        $item->point = $request->point;
        $item->feature1 = $request->feature1 ? : 0;
        //$item->feature2 = $request->feature2;
        $item->feature2 = rand(9999,99999);
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
        $admin = Auth::guard('admin')->user();
        $categories = \App\Category::all();
        if($admin->hasRole('管理员')){
            $dealers = \App\Dealer::all();
        }
        else{
            $role_names = $admin->getRoleNames();
            $dealers = \App\Dealer::whereIn('name', $role_names)->get();
        }
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
        $item->coupon_value = $request->coupon_value ? : 0;
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
