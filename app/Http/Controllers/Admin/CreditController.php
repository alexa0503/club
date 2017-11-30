<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = \DB::table('discuz_common_credit_log as cl')
            ->leftJoin('discuz_common_credit_log_field as lf','lf.logid','=','cl.logid')
            ->leftJoin('discuz_common_member as m','m.uid','=','cl.uid')
            ->leftJoin('verifies as v','v.uid','cl.uid')
            ->select('cl.logid','m.uid','m.username','cl.extcredits1','extcredits4', 'lf.title', 'lf.text','cl.dateline','v.model_code')
            ->orderBy('cl.logid', 'DESC');

        if(null != $request->keywords){
            $model->where('m.uid','=', $request->keywords);
            $model->orWhere('m.username', 'LIKE', '%'.$request->keywords.'%');
        }
        if(null != $request->date1){
            $model->where('cl.dateline','>=', strtotime($request->date1 ." 00:00:00"));
        }
        if(null != $request->date2){
            $model->where('cl.dateline','<=', strtotime($request->date2 ." 23:59:59"));
        }

        $rows = $model->paginate(20);
        //print_r($rows->total());die;
        return view('admin.credit.index',[
            'rows' => $rows,
            'requestAll' => $request->all(),
        ]);
    }

    public function export(Request $request){
        set_time_limit(0);
        $model = \DB::table('discuz_common_credit_log as cl')
            ->leftJoin('discuz_common_credit_log_field as lf','lf.logid','=','cl.logid')
            ->leftJoin('discuz_common_member as m','m.uid','=','cl.uid')
            ->leftJoin('verifies as v','v.uid','cl.uid')
            ->select('cl.logid','m.uid','m.username','cl.extcredits1','extcredits4', 'lf.text','cl.dateline','v.model_code')
            ->orderBy('cl.logid', 'DESC');

        if(null != $request->keywords){
            $model->where('discuz_common_member.uid','=', $request->keywords);
            $model->orWhere('m.username', 'LIKE', '%'.$request->keywords.'%');
        }
        if(null != $request->date1){
            $model->where('cl.dateline','>=', strtotime($request->date1 ."00:00:00"));
        }
        if(null != $request->date2){
            $model->where('cl.dateline','<=', strtotime($request->date2 ."23:59:59"));
        }

        $date = date("Y_m_d_").rand(1000,9999);
        $filename = "credit_{$date}.csv";
        $filename = iconv("utf-8", "gb2312", $filename);
        $fp = fopen(public_path("downloads/datacsv/".$filename), 'w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        $title = ["ID","UID","用户名","积分","风迷币","原因","消费时间","车型"];
        fputcsv($fp, $title);

        $model->chunk(10000, function($list) use ($fp){
            foreach ($list as $k => $v) {
                $v->dateline = date("Y-m-d H:i:s", $v->dateline);
                fputcsv($fp, Helper::object_array($v));
            }
            //return false;
        });
        fclose($fp);
        return response()->download("downloads/datacsv/".$filename);
    }



    public function dms(Request $request){
        $model = \DB::table('owner_logs as l')
            ->leftJoin('discuz_common_member as m','m.uid','=','l.uid')
            ->leftJoin('verifies as v','v.uid','l.uid')
            ->select('l.id','m.uid','m.username','l.score_id','l.rono','l.point','l.coin', 'l.reason','l.spent_at','v.model_code','l.dealer')
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
        $rows = $model->paginate(20);

        return view('admin.credit.dms',[
            'rows' => $rows,
            'requestAll' => $request->all(),
        ]);
    }

    public function exportdms(Request $request){
        set_time_limit(0);
        $model = \DB::table('owner_logs as l')
            ->leftJoin('discuz_common_member as m','m.uid','=','l.uid')
            ->leftJoin('verifies as v','v.uid','l.uid')
            ->select('l.id','m.uid','m.username','l.score_id','l.rono','l.point','l.coin', 'l.reason','l.spent_at','v.model_code','l.dealer')
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

        $date = date("Y_m_d_").rand(1000,9999);
        $filename = "credit_{$date}.csv";
        $filename = iconv("utf-8", "gb2312", $filename);
        $fp = fopen(public_path("downloads/datacsv/".$filename), 'w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        $title = ["ID","UID","用户名","SCORE ID","RONO","积分","风迷币","原因","消费时间","车型","经销商代码"];
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
        return view('admin.credit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'username.*' => '请输入用户名~',
            'extcredits1.*' => '请输入积分，且只能为整数~',
            'extcredits4.*' => '请输入风迷币，且只能为整数~',
            'title.*' => '请输入变更理由标题~',
            'text.*' => '请输入变更理由描述~'
        ];
        $validator = \Validator::make($request->all(), [
            'username' => 'required',
            'extcredits1' => [
                'required',
                'regex:/^\d*$/'
            ],
            'extcredits4' => [
                'required',
                'regex:/^\d*$/'
            ],
            'title' => 'required',
            'text' => 'required',
        ], $messages);
        $validator->after(function ($validator) use ($request) {
            if( null != $request->username ){
                $array = explode(',', $request->username);
                foreach($array as $v){
                    $count = \DB::table('discuz_common_member')->where('username', '=', $v)->count();
                    if($count == 0 && !empty($v)){
                        $validator->errors()->add('username', '用户：'.$v.' 不存在~');
                    }
                }
            }
        });
        if ($validator->fails()) {
            return response($validator->errors(), 422);
        }
        $arr_username = explode(',', $request->username);
        foreach($arr_username as $_username){
            $user = \DB::table('discuz_common_member')->where('username', '=', $_username)->first();
            $uid = $user->uid;
            $user_count = \DB::table('discuz_common_member_count')->where('uid',$uid)->first();
            //更新积分
            \DB::table('discuz_common_member_count')
                ->where('uid',$uid)
                ->update([
                    'extcredits1' => $user_count->extcredits1 + $request->extcredits1,
                    'extcredits4' => $user_count->extcredits4 + $request->extcredits4,
                ]);
            $logid = \DB::table('discuz_common_credit_log')->insertGetId([
                'uid' => $uid,
                'operation'=>'',
                'relatedid'=>1,
                'dateline'=>time(),
                'extcredits1'=>$request->extcredits1,
                'extcredits4'=>$request->extcredits4,
                'extcredits2'=>0,
                'extcredits3'=>0,
                'extcredits5'=>0,
                'extcredits6'=>0,
                'extcredits7'=>0,
                'extcredits8'=>0,
            ]);
            //插入日志
            \DB::table('discuz_common_credit_log_field')->insert([
                'logid'=>$logid,
                'title'=>$request->title,
                'text'=>$request->text,
            ]);
        }

        return response(['ret'=>0,'msg'=>'','url'=>route('credit.index')],200);
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
