<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PointsCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'points:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //工单取消
        $score_id = '0';
        while (true) {
            $this->info($score_id);
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY05SOAP?wsdl",['exceptions' => 0]);
            $options = [
                'in'=>json_encode([
                    'frame_number'=>'',
                    'score_id' => $score_id,
                ])
            ];
            $response = $client->__soapCall("CancelOrderAccount", array($options));
            if( !is_soap_fault($response)){
                $result = json_decode($response->out,true);
            }
            else{
                //trigger_error("SOAP Fault: (faultcode: {$response->faultcode}, faultstring: {$response->faultstring})", E_USER_ERROR);
                $result = null;
            }
            //var_dump($result);
            if($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])){
                $score_id = end($result['data'])['SCORE_ID'];
                foreach ($result['data'] as $data){
                    $count = \App\OwnerLog::where('score_id',$data['SCORE_ID'])->withTrashed()->count();
                    if( $count > 0 ){
                        continue;
                    }
                    $verify = \App\Verify::where('frame_number', $data['vin'])->first();
                    if( null == $verify ){
                        continue;
                    }
                    $data['title'] = '车主工单取消';
                    $data['generate_way'] = 2;
                    $data['verify_id'] = $verify->id;
                    \App\Helpers\Helper::updateLog($verify->uid,$data);
                    \App\OwnerLog::where('rono', $data['Rono'])->where('generate_way','1')->delete();
                }
            }
            else{
                return false;
            }
        }
    }
}
