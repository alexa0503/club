<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecommendedCar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recommended:car';

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
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY09SOAP?wsdl", ['exceptions' => 0]);
        $options = [
        ];
        $response = $client->__soapCall("QueryRecomInfo", array($options));
        
        if (!is_soap_fault($response)) {
            $result = json_decode($response->out, true);
        } else {
            //trigger_error("SOAP Fault: (faultcode: {$response->faultcode}, faultstring: {$response->faultstring})", E_USER_ERROR);
            $result = null;
        }
        //var_dump($result);
        $result['ret'] = 0;
        $result['data'] = [
            [
                'spent_at' => '2018-03-23 11:54:23.0',
                'customerVin' => 'LVZA53P99HC200692',
                'modelCode' => 'F506S',
                'vin' => 'LVZA53P91GC659665',
                'dealerCode' => 'F28-0001',
                'points' => '3600',
                'resultId' => '1000000005',
                'type' => '推荐购车'
            ],
            [
                'spent_at' => '2018-04-23 20:26:19.0',
                'customerVin' => 'LVZA53P99HC200692',
                'modelCode' => 'F506S',
                'vin' => 'LVZA53P91GC659665',
                'dealerCode' => 'F28-0001',
                'points' => '3600',
                'resultId' => '1000000006',
                'type' => '推荐购车'
            ]
        ];
        if ($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as $data) {
                $data['SCORE_ID'] = $data['resultId'];
                $data['Type'] = $data['type'];
                $data['Dealer'] = $data['dealerCode'];
                $data['Coin'] = $data['points'];
                $data['Point'] = 0;
                $data['Reason'] = $data['type'];
                $data['recommended_model_code'] = $data['modelCode'];
                $data['recommended_frame_number'] = $data['customerVin'];
                $data['Rono'] = '';

                $log = \App\OwnerLog::where('score_id', $data['SCORE_ID'])->where('generate_way',3)->withTrashed()->first();
                if ($log != null) {
                    continue;
                }
                $verify = \App\Verify::where('frame_number', $data['vin'])->first();
                if (null == $verify) {
                    continue;
                }

                $data['title'] = '车主奖励';
                $data['generate_way'] = 3;
                $data['verify_id'] = $verify->id;
                \App\Helpers\Helper::updateLog($verify->uid, $data);
                \App\Helpers\DiscuzHelper::checkUserGroup($verify->uid);//更新用户等级
            }
        } else {
            if ($result) {
                $this->info($result['ret']);
            }
            return false;
        }
    }
}
