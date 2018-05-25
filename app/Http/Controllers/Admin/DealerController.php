<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

class DealerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:管理员','permission:供应商管理']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealers = \App\Dealer::paginate(20);
        return view('admin.dealer.index',['items'=>$dealers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.dealer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:dealers|max:255',
            'qq' => 'required',
            'tel' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $dealer = new \App\Dealer;
        $dealer->name = $request->name;
        $dealer->qq = $request->qq;
        $dealer->tel = $request->tel;
        $dealer->intro = $request->intro ?: '';
        $dealer->save();
        return response()->json(['ret' => 0, 'url' => route('dealer.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dealer = \App\Dealer::find($id);
        return view('admin.dealer.edit',['dealer'=>$dealer]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:dealers,name,'.$id.'|max:255',
            'qq' => 'required',
            'tel' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $dealer = \App\Dealer::find($id);
        $dealer->name = $request->name;
        $dealer->qq = $request->qq;
        $dealer->tel = $request->tel;
        $dealer->intro = $request->intro ?: '';
        $dealer->save();
        return response()->json(['ret' => 0, 'url' => route('dealer.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( \App\Item::where('dealer_id', $id)->withTrashed()->count() > 0){
            return response()->json(['ret'=>1001, 'msg'=>'产品中含有该供应商的产品，无法删除']);
        }
        $dealer = \App\Dealer::find($id);
        $dealer->delete();
        return response()->json(['ret'=>0]);
    }
}
