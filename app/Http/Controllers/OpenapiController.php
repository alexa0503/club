<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DiscuzHelper;
use DB;
use Validator;

class OpenapiController extends Controller{

	public function __construct(Request $request){
		$messages = [
            'Vin.required' => '参数不能为空',
            'Vin.regex' => '格式错误',
        ];
        $validator = Validator::make($request->all(), [
            'Vin' => [
                'required',
                'regex:/^[a-z0-9A-Z]{17}$/',
            ],
        ], $messages);

        if ($validator->fails()) {
            $this->jsond(0,$validator->errors()->first());
        }
	}


	public function getUserinfo(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_member_count as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_member as c","c.uid","=","a.uid")
            ->leftJoin("discuz_common_usergroup as d","d.groupid","=","c.groupid")
            ->where("a.frame_number","=",$request->Vin)
            ->select("a.uid","b.extcredits1","b.extcredits4","c.groupid","d.grouptitle")
            ->first();
        /*$info = DB::select("select a.uid,b.extcredits1,b.extcredits4,
            CASE groupid 
            WHEN 11 THEN '银牌'
            WHEN 12 THEN '金牌'
            WHEN 13 THEN '铂金'
            WHEN 14 THEN '钻石'
            ELSE '铜牌'
            END as groupname
            from verifies a,discuz_common_member_count b,discuz_common_member c 
            where a.frame_number='{$request->vin}' and a.uid=c.uid and a.uid=b.uid
            limit 1");*/
            if($info){
                $this->jsond(1,"SUCC",$info);
            }else{
                $this->jsond(0,"ERROR");
            }
	}

	public function getExtcredits1(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_credit_log as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_credit_log_field as c","c.logid","=","b.logid")
            ->leftJoin("discuz_forum_activity as d","d.tid","=","b.relatedid")
            ->where("a.frame_number","=",$request->Vin)
            ->where("b.extcredits1","<>","0")
            ->select("b.extcredits1","b.operation","b.dateline","c.title","c.text","d.place","d.class")
            ->get();
        /*$info = DB::select("select a.uid,b.extcredits1,c.title,c.text
            from verifies a,discuz_common_credit_log b,discuz_common_credit_log_field c 
            where a.frame_number='{$request->vin}' and a.uid=b.uid and b.logid=c.logid
            limit 1");*/
            if(!$info->isEmpty()){
                $this->jsond(1,"SUCC",$info);
            }else{
                $this->jsond(0,"ERROR");
            }
	}

    public function getExtcredits4(Request $request){
        $info = DB::table("verifies as a")
            ->leftJoin("discuz_common_credit_log as b","b.uid","=","a.uid")
            ->leftJoin("discuz_common_credit_log_field as c","c.logid","=","b.logid")
            ->leftJoin("discuz_forum_activity as d","d.tid","=","b.relatedid")
            ->where("a.frame_number","=",$request->Vin)
            ->where("b.extcredits4","<>","0")
            ->select("b.extcredits4","b.operation","b.dateline","c.title","c.text","d.place","d.class")
            ->get();
        /*$info = DB::select("select a.uid,b.extcredits1,c.title,c.text
            from verifies a,discuz_common_credit_log b,discuz_common_credit_log_field c 
            where a.frame_number='{$request->vin}' and a.uid=b.uid and b.logid=c.logid
            limit 1");*/
            if(!$info->isEmpty()){
                $this->jsond(1,"SUCC",$info);
            }else{
                $this->jsond(0,"ERROR");
            }
    }

	public function jsond($result, $msg="", $info = array()){
		echo json_encode(array("result"=>$result,"msg"=>$msg,"info"=>$info));
		exit;
	}
}