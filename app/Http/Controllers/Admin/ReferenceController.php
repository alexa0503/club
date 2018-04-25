<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;

class ReferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:管理员','permission:认证记录']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = \DB::table('owner_logs as l')
            ->leftJoin('discuz_common_member as m','m.uid','=','l.uid')
            ->leftJoin('verifies as v','v.uid','l.uid')
            ->select('l.id','m.uid','m.username','l.score_id','l.rono','l.point','l.coin', 'l.reason','l.spent_at','v.model_code','l.dealer','l.recommended_frame_number','l.recommended_model_code')
            ->orderBy('l.id', 'DESC');
        if(null != $request->keywords){
            $model->where('m.uid','=', $request->keywords);
            $model->orWhere('m.username', 'LIKE', '%'.$request->keywords.'%');
        }
        if(null != $request->date1){
            $model->where('l.spent_at','>=', $request->date1 ." 00:00:00");
        }
        if(null != $request->date2){
            $model->where('l.spent_at','<=', $request->date2 ." 23:59:59");
        }
        
        $model->where('l.generate_way','=', '3');
        $rows = $model->paginate(20);

        return view('admin.reference.index',[
            'rows' => $rows,
            'requestAll' => $request->all(),
        ]);
    }

    
    public function export(Request $request){
        set_time_limit(0);
        $model = \DB::table('owner_logs as l')
            ->leftJoin('discuz_common_member as m','m.uid','=','l.uid')
            ->leftJoin('verifies as v','v.uid','l.uid')
            ->select('l.id','m.uid','m.username','l.point','l.coin', 'l.reason','l.spent_at','v.model_code','l.dealer','l.recommended_frame_number','l.recommended_model_code')
            ->orderBy('l.id', 'DESC');
        if(null != $request->keywords){
            $model->where('m.uid','=', $request->keywords);
            $model->orWhere('m.username', 'LIKE', '%'.$request->keywords.'%');
        }
        if(null != $request->date1){
            $model->where('l.spent_at','>=', $request->date1 ." 00:00:00");
        }
        if(null != $request->date2){
            $model->where('l.spent_at','<=', $request->date2 ." 23:59:59");
        }

        $model->where('l.generate_way','=', '3');

        $date = date("Y_m_d_").rand(1000,9999);
        $filename = "reference_{$date}.csv";
        $filename = iconv("utf-8", "gb2312", $filename);
        $fp = fopen(public_path("downloads/datacsv/".$filename), 'w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        $title = ["ID","UID","用户名","积分","风迷币","原因","消费时间","车型","经销商代码","推荐购车车架号","推荐购车车型"];
        fputcsv($fp, $title);

        $model->chunk(10000, function($list) use ($fp){
            foreach ($list as $k => $v) {
                fputcsv($fp, Helper::object_array($v));
            }
            //return false;
        });
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
