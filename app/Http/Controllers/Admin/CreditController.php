<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = \DB::table('discuz_common_credit_log')
            ->join('discuz_common_credit_log_field', 'discuz_common_credit_log.logid','=','discuz_common_credit_log_field.logid')
            ->join('discuz_common_member', 'discuz_common_member.uid', '=', 'discuz_common_credit_log.uid')
            ->select('discuz_common_credit_log.*', 'discuz_common_credit_log_field.title', 'discuz_common_credit_log_field.text', 'discuz_common_member.username')
            ->orderBy('discuz_common_credit_log.dateline', 'DESC');
        if(null != $request->keywords){
            $model->where('discuz_common_member.uid','=', $request->keywords);
            $model->orWhere('discuz_common_member.username', 'LIKE', '%'.$request->keywords.'%');
        }
        $rows = $model->paginate(20);
        return view('admin.credit.index',[
            'rows' => $rows
        ]);
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