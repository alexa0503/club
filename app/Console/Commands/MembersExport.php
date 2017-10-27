<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class MembersExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'members:export {n?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export members info';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $n =  null == $this->argument('n') ? 1 :  $this->argument('n');
        $this->logsMatch($n);
        //$this->logsExport($n);
        //$this->membersExport($n);
        //$this->logsExport($n);
    }
    public function logsMatch($n)
    {
        $arr_title = [
            '车架号',
            '姓名',
            '时间',
            '备注',
        ];
        $filename = 'd1-0'.$n.'.csv';
        $file = fopen(storage_path($filename), 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        //fputcsv($file, $arr_title);

        $filename1 = 'dms-02.csv';
        $handle = fopen(storage_path($filename1), 'r');
        while(!feof($handle)){
            $line = fgets($handle);
            $arr = explode(',', trim($line));
            $log = DB::table('owner_logs')->where('score_id', $arr[1])->first();
            if( null == $log ){
                fputcsv($file, $arr);
            }
            //$this->info($verify)
            //break;
        }
        fclose($file);
    }
    public function checkExport()
    {
        $arr_title = [
            '车架号',
            '姓名',
            '时间',
            '备注',
        ];
        $filename = 'check-0'.$n.'.csv';
        $file = fopen(storage_path($filename), 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($file, $arr_title);

        $filename1 = 'bduser10.16.csv';
        $handle = fopen(storage_path($filename1), 'r');
        while(!feof($handle)){
            $line = fgets($handle);
            $arr = explode(',', trim($line));
            $verify = DB::table('verifies')->where('frame_number', trim($arr[0]))->first();
            if( $verify == null ){
                $arr[] = '无该车架号记录';
                fputcsv($file, $arr);
            }
            elseif($verify->id_card != trim($arr[1])){
                $arr[] = '车架号与姓名不匹配，数据库姓名：'.$verify->id_card;
                fputcsv($file, $arr);
            }
            //$this->info($verify)
            //break;
        }
        fclose($file);
    }
    public function membersExport()
    {
        $n =  null == $this->argument('n') ? 1 :  $this->argument('n');
        $filename = 'logs-钻石会员'.$n.'.csv';
        //$this->info(storage_path($filename));
        $file = fopen(storage_path($filename), 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        $arr_title = [
            'uid',
            '用户名',
            '积分',
            '风迷币',
            '理由',
            '时间',
        ];
        fputcsv($file, $arr_title);
        for ($i=($n-1)*5; $i < $n*5; $i++) {
            $members = DB::table('discuz_common_member')
                ->join('discuz_common_member_count','discuz_common_member.uid','=','discuz_common_member_count.uid')
                ->select('discuz_common_member.uid','discuz_common_member.regdate','discuz_common_member.username','discuz_common_member_count.extcredits1','discuz_common_member_count.extcredits4')
                ->where('discuz_common_member.groupid','=','14')
                ->skip($i*10000)
                ->take(10000)
                ->orderBy('discuz_common_member.uid','ASC')
                ->get();
            if( null == $members){
                break;
            }

            foreach( $members as $member ){
                $logs = DB::table('discuz_common_credit_log')
                    ->join('discuz_common_credit_log_field','discuz_common_credit_log.logid','=','discuz_common_credit_log_field.logid')
                    ->select('discuz_common_credit_log.extcredits1','discuz_common_credit_log.extcredits4','discuz_common_credit_log.dateline','discuz_common_credit_log_field.title','discuz_common_credit_log_field.text')
                    ->where('discuz_common_credit_log.uid','=', $member->uid)
                    ->get();
                $arr = [];
                foreach( $logs as $log){
                    //$arr[] = '积分:'.$log->extcredits1.',风迷币:'.$log->extcredits4.',理由:'.$log->text;
                    $content = [
                        $member->uid,
                        $member->username,
                        //$member->extcredits1,
                        //$member->extcredits4,
                        //strtotime($member->regdate),
                        $log->extcredits1,
                        $log->extcredits4,
                        $log->text,
                        date('Y-m-d H:i:s',$log->dateline),
                        //implode("\n",$arr),
                    ];
                    fputcsv($file, $content);
                }
            }
        }
        fclose($file);
    }
    public function logsExport($n)
    {
        $filename = 'logs-铂金会员-0'.$n.'.csv';
        //$this->info(storage_path($filename));
        $file = fopen(storage_path($filename), 'w');
        fwrite($file, chr(0xEF).chr(0xBB).chr(0xBF));
        $arr_title = [
            'uid',
            '用户名',
            '积分',
            '风迷币',
            '消费时间',
            '备注',
            'SCORE ID',
            '经销商',
            'RONO',
            'type'
        ];
        fputcsv($file, $arr_title);
        for ($i=($n-1)*5; $i < $n*5; $i++) {
            $logs = DB::table('owner_logs')
                //->join('verifies','verifies.uid','=','owner_logs.uid')
                ->join('discuz_common_member','discuz_common_member.uid','=','owner_logs.uid')
                //->where('owner_logs.spent_at', '>=', '2017-09-29')
                //->where('owner_logs.spent_at', '<', '2017-10-18')
                ->where('discuz_common_member.groupid','=','13')
                ->select('owner_logs.uid','discuz_common_member.username','owner_logs.point','owner_logs.coin','owner_logs.spent_at','owner_logs.generate_way','owner_logs.reason','owner_logs.score_id','owner_logs.dealer','owner_logs.rono','owner_logs.type')
                ->orderBy('owner_logs.spent_at','ASC')
                ->skip($i*100000)
                ->take(100000)
                ->get();
            if( null == $logs){
                break;
            }
            foreach( $logs as $log ){
                $content = [
                    $log->uid,
                    $log->username,
                    $log->point,
                    $log->coin,
                    $log->spent_at,
                    $log->reason,
                    $log->score_id,
                    $log->dealer,
                    $log->rono,
                    $log->type,
                ];
                fputcsv($file, $content);
            }
            $this->info($i.','.count($logs));
        }

        fclose($file);
    }
}
