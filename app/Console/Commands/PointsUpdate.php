<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\DiscuzHelper;

class PointsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update owner\'s points';

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
        $verifies = \App\Verify::where('status','>=',0)->get();
        foreach($verifies as $verify){
            $uid = $verify->uid;
            $frame_number = $verify->frame_number;//车架号

            $_log = \App\OwnerLog::where('verify_id', $verify->id)->orderBy('score_id','DESC')->first();
            if( $_log == null ){
                $score_id = 0;
            }
            else{
                $score_id = $_log->score_id;
            }

            //新增积分
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$frame_number,
                    'score_id' => $score_id,
                ])
            ];
            $response = $client->__soapCall("queryPartsInfo", array($options));
            $result = json_decode($response->out,true);
            \Log::info('积分新增['.$frame_number.']:'.$response->out);
            if($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])){
                foreach ($result['data'] as $data){
                    $count = \App\OwnerLog::where('score_id', $data['SCORE_ID'])->count();
                    if( $count > 0 ){
                        continue;
                    }
                    $data['title'] = '车主奖励';
                    $data['generate_way'] = 1;
                    $data['verify_id'] = $verify->id;
                    \App\Helpers\Helper::updateLog($uid,$data);
                }
            }

            //工单取消
            $_log = \App\OwnerLog::where('verify_id', $verify->id)->where('generate_way',2)->orderBy('score_id','DESC')->first();
            if( $_log == null ){
                $score_id = 0;
            }
            else{
                $score_id = $_log->score_id;
            }
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY05SOAP?wsdl");
            $options = [
                'in'=>json_encode([
                    'frame_number'=>$frame_number,
                    'score_id'=>$score_id,
                ])
            ];
            $response = $client->__soapCall("CancelOrderAccount", array($options));
            $result1 = json_decode($response->out,true);
            \Log::info('工单取消['.$frame_number.']:'.$response->out);
            //var_dump($result1);
            if($result1 && $result1['ret'] == 0 && isset($result1['data']) && is_array($result1['data'])){
                foreach ($result1['data'] as $data){
                    $count = \App\OwnerLog::where('score_id', $data['SCORE_ID'])->count();
                    if( $count > 0 ){
                        continue;
                    }
                    /*
                    \App\OwnerLog::where('uid', $uid)
                        ->where('generate_way', 2)
                        ->where('rono', $data['Rono'])
                        ->delete();
                    */
                    $data['title'] = '车主工单取消';
                    $data['generate_way'] = 2;
                    $data['verify_id'] = $verify->id;
                    \App\Helpers\Helper::updateLog($uid,$data);
                    \App\OwnerLog::where('rono', $data['Rono'])->where('generate_way','1')->delete();
                }
            }
            //$verify->status = 1;
            //$verify->save();
        }
    }
}
