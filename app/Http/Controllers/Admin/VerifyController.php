<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use DB;

class VerifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = array();
        //开始时间
        if($request->has('date1')){
            $where[] = ['created_at', '>=', "{$request->date1} 00:00:00"];
        }
        //结束时间
        if($request->has('date2')){
            $where[] = ['created_at', '<=', "{$request->date2} 23:59:59"];
        }
        //车型
        if($request->has('model_code')){
            $where[] = ['model_code', '=', $request->model_code];
        }
        //数据来源
        if($request->has('datafrom')){
            if($request->datafrom == 1){
                $where[] = ['m.email',"=",""];
            }else if($request->datafrom == 2){
                $where[] = ['m.email',"!=",""];
            }
            $items = \App\Verify::leftJoin('discuz_common_member as m',"verifies.uid","=","m.uid")
                    ->where($where)->paginate(20);
        }else{
            $items = \App\Verify::where($where)->paginate(20);
        }

        //print_r($items->links());die;
        
        $model_codes = \App\Verify::groupBy("model_code")->select("model_code")->get();
        return view('admin.verify.index',[
            'items' => $items,
            'model_codes' => $model_codes,
            'requestAll' => $request->all(),
        ]);
    }

    public function export(Request $request){
        set_time_limit(0);
        $where = array();
        //开始时间
        if($request->has('date1')){
            $where[] = ['a.created_at', '>=', "{$request->date1} 00:00:00"];
        }
        //结束时间
        if($request->has('date2')){
            $where[] = ['a.created_at', '<=', "{$request->date2} 23:59:59"];
        }
        //车型
        if($request->has('model_code')){
            $where[] = ['a.model_code', '=', $request->model_code];
        }
        //数据来源
        if($request->has('datafrom')){
            if($request->datafrom == 1){
                $where[] = ['m.email',"=",""];
            }else if($request->datafrom == 2){
                $where[] = ['m.email',"!=",""];
            }
            
        }

        $date = date("Y_m_d_").rand(1000,9999);
        $filename = "verify_{$date}.csv";
        $filename = iconv("utf-8", "gb2312", $filename);
        $fp = fopen(public_path("downloads/datacsv/".$filename), 'w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        $title = ["编号","用户名","车架号","身份证号","车型","创建时间"];
        fputcsv($fp, $title);

        \DB::table("verifies as a")
            ->leftJoin('discuz_common_member as m',"a.uid","=","m.uid")
            ->where($where)
            ->select("a.id","m.username","a.frame_number","a.id_card","a.model_code","a.created_at")
            ->orderBy("a.id","asc")
            ->chunk(10000, function($list) use ($fp){
                foreach ($list as $k => $v) {
                    fputcsv($fp, Helper::object_array($v));
                }
                //return false;
            });
        //print_r($items);die;
        fclose($fp);
        return response()->download("downloads/datacsv/".$filename);
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
        //
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
        //
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
