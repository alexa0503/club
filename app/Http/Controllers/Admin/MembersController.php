<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use DB;

class MembersController extends Controller
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
            $where[] = ['m.regdate', '>=', strtotime($request->date1 . " 00:00:00")];
        }
        //结束时间
        if($request->has('date2')){
            $where[] = ['m.regdate', '<=', strtotime($request->date2 . " 23:59:59")];
        }
        //数据来源
        if($request->has('datafrom')){
            if($request->datafrom == 1){
                $where[] = ['m.email',"=",""];
            }else if($request->datafrom == 2){
                $where[] = ['m.email',"!=",""];
            }
        }

        $items = DB::table("discuz_common_member as m")
                    ->join('discuz_common_member_count as c',"c.uid","=","m.uid")
                    ->join("discuz_common_usergroup as u","u.groupid","=","m.groupid")
                    ->select("m.uid","m.username","c.extcredits1","c.extcredits4","m.email","u.grouptitle","m.regdate")
                    ->where($where)
                    ->paginate(20);
                    //print_r($items);die;
        return view('admin.members.index',[
            'items' => $items,
            'requestAll' => $request->all(),
        ]);
    }

    public function export(Request $request)
    {
        $where = array();
        //开始时间
        if($request->has('date1')){
            $where[] = ['m.regdate', '>=', strtotime($request->date1 . " 00:00:00")];
        }
        //结束时间
        if($request->has('date2')){
            $where[] = ['m.regdate', '<=', strtotime($request->date2 . " 23:59:59")];
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
        $filename = "members_{$date}.csv";
        $filename = iconv("utf-8", "gb2312", $filename);
        $fp = fopen(public_path("downloads/datacsv/".$filename), 'w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        $title = ["编号","用户名","积分","风迷币","邮箱","等级","创建时间"];
        fputcsv($fp, $title);

        DB::table("discuz_common_member as m")
            ->join('discuz_common_member_count as c',"c.uid","=","m.uid")
            ->join("discuz_common_usergroup as u","u.groupid","=","m.groupid")
            ->select("m.uid","m.username","c.extcredits1","c.extcredits4","m.email","u.grouptitle","m.regdate")
            ->where($where)
            ->orderBy("m.uid","asc")
            ->chunk(10000, function($list) use ($fp){
                foreach ($list as $k => $v) {
                    $v->regdate = date("Y-m-d H:i:s",$v->regdate);
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
