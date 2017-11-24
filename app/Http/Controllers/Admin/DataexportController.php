<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use DB;

class DataexportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.dataexport.index');
    }

    public function export(Request $request)
    {
        $where = array();
        if($request->has('date1')){
            $where[] = ['v.created_at', '>=', "{$request->date1} 00:00:00"];
        }
        if($request->has('date2')){
            $where[] = ['v.created_at', '<=', "{$request->date2} 23:59:59"];
        }
        //粉丝总数
        //实名认证会员总数（多少来于车友会？多少来于移动CRM？）
        //各等级会员数
        //上一周新增粉丝数、新增实名认证会员数（上周一的24：00到周日的23：59分）
        //330、360/370、580、S560，四种车型的实名认证会员数各是多少？
        //总的产生的风迷币与积分数
        //上一周产生的风迷币与积分明细表（上周一的24：00到周日的23：59分）
        //截止上周日23：59分所有实名认证的会员明细表包含字段
        //用户名   会员等级    积分  风迷币 认证车架号   认证车型    注册时间

        $path_url = rand(1000,9999);
        $dir_path = public_path()."/downloads/datacsv/".date("Ym")."/".date("Ymd").$path_url;
        $download_path = public_path()."/downloads/datacsv_downlaod/".date("Ym")."/".date("Ymd").$path_url;
        Helper::mk_dir($dir_path);
        Helper::mk_dir($download_path);

        //获取全部用户数据列表
        $this->createAllUserDataList($dir_path, $where);
        

        //获取积分
        $this->createAllCreditDataList($dir_path, $where);

        //创建压缩包并且完成下载
        $zip = new \ZipArchive();
        if ($zip->open($download_path.'.zip', \ZipArchive::CREATE) === TRUE) {
            $this->createZip(opendir($dir_path),$zip,$dir_path); 
            $zip->close(); //关闭处理的zip文件
            //删除文件夹
            //$this->delDirAndFile($dir_path,true);
            //下载
            header("Cache-Control: public"); 
            header("Content-Description: File Transfer"); 
            header('Content-disposition: attachment; filename='.basename($path_url.'.zip')); //文件名   
            header("Content-Type: application/zip"); //zip格式的   
            header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件    
            header('Content-Length: '. filesize($download_path.'.zip')); //告诉浏览器，文件大小   
            @readfile($download_path.'.zip');
            //return redirect(asset($filename));
        }else{
            die("下载失败");
        }
        echo "OVER";
        exit;
    }

    public function createAllCreditDataList($dir_path, $where = array()){
        $filename = "全部积分风迷币记录".date("YmdHis");
        $filename = iconv("utf-8", "gb2312", $filename);
        $file = fopen($dir_path."/".$filename.'.csv', 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        $title = ["编号","邮箱","昵称","产生积分","产生风迷币","来源","描述","产生时间"];
        fputcsv($file, $title);
        $data = DB::table("discuz_common_credit_log as l")
                ->leftJoin("discuz_common_member as m","l.uid","=","m.uid")
                ->leftJoin("discuz_common_credit_log_field as f","f.logid","=","l.logid")
                ->select("m.uid","m.email","m.username","l.extcredits1","l.extcredits4","f.title","f.text","l.dateline")
                //->where($where)
                ->orderBy("l.uid","desc")
                ->chunk(10000, function($list) use ($file){
                    foreach ($list as $key => $value) {
                        $value->dateline = date("Y-m-d H:i:s", $value->dateline);
                        fputcsv($file, Helper::object_array($value));
                    }
                    //return false;
                });
        fclose($file);
        return true;
    }

    public function createAllUserDataList($dir_path, $where = array()){
        $filename = "全部用户数据".date("YmdHis");
        $filename = iconv("utf-8", "gb2312", $filename);
        $file = fopen($dir_path."/".$filename.'.csv', 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        $title = ["编号","邮箱","昵称","注册时间","VIN码","姓名","购买车型","认证时间","等级","积分","风迷币"];
        fputcsv($file, $title);
        $data = DB::table("discuz_common_member as m")
                ->leftJoin("verifies as v","v.uid","=","m.uid")
                ->leftJoin("discuz_common_member_count as mc","mc.uid","=","m.uid")
                ->leftJoin("discuz_common_usergroup as u","u.groupid","=","m.groupid")
                ->select("m.uid","m.email","m.username","m.regdate","v.frame_number","v.id_card","v.model_code","v.created_at","u.grouptitle","mc.extcredits1","mc.extcredits4")
                //->where($where)
                ->orderBy("m.uid","desc")
                ->chunk(10000, function($list) use ($file){
                    foreach ($list as $key => $value) {
                        $value->regdate = date("Y-m-d H:i:s", $value->regdate);
                        fputcsv($file, Helper::object_array($value));
                    }
                    //return false;
                });
        fclose($file);
        return true;
    }

    

    function createZip($openFile,$zipObj,$sourceAbso,$newRelat = '')  {  
        while(($file = readdir($openFile)) != false)  
        {  
            if($file=="." || $file=="..")  
                continue;  
              
            /*源目录路径(绝对路径)*/  
            $sourceTemp = $sourceAbso.'/'.$file;  
            /*目标目录路径(相对路径)*/  
            $newTemp = $newRelat==''?$file:$newRelat.'/'.$file;  
            if(is_dir($sourceTemp))  
            {  
                //echo '创建'.$newTemp.'文件夹<br/>';  
                $zipObj->addEmptyDir($newTemp);/*这里注意：php只需传递一个文件夹名称路径即可*/  
                $this->createZip(opendir($sourceTemp),$zipObj,$sourceTemp,$newTemp);  
            } 
            if(is_file($sourceTemp))  
            {  
                //echo '创建'.$newTemp.'文件<br/>';  
                $zipObj->addFile($sourceTemp,$newTemp);  
            }  
        }  
    }  

    public function delDirAndFile($path, $delDir = FALSE) {
        $handle = opendir($path);
        if ($handle) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..")
                    is_dir("$path/$item") ? $this->delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
            }
            closedir($handle);
            if ($delDir)
                return rmdir($path);
        }else {
            if (file_exists($path)) {
                return unlink($path);
            } else {
                return FALSE;
            }
        }
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
