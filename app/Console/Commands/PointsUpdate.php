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
    protected $signature = 'points:update {is_latest?}';

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
        ini_set('memory_limit', '1024M');
        $is_latest = (null == $this->argument('is_latest')) ? 'n' :  strtolower($this->argument('is_latest'));
        $score_id = $is_latest == 'y' ? '' : '0';

        while (true) {
            $this->info($score_id);
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl", ['exceptions' => 0]);
            $options = [
                'in'=>json_encode([
                    'frame_number'=>'',
                    'score_id' => $score_id,
                ])
            ];
            $response = $client->__soapCall("queryPartsInfo", array($options));
            if (!is_soap_fault($response)) {
                $result = json_decode($response->out, true);
            } else {
                //trigger_error("SOAP Fault: (faultcode: {$response->faultcode}, faultstring: {$response->faultstring})", E_USER_ERROR);
                $result = null;
            }
            if ($result && $result['ret'] == 0 && isset($result['data']) && is_array($result['data'])) {
                if ($is_latest != 'y') {
                    $score_id = end($result['data'])['SCORE_ID'];
                }

                foreach ($result['data'] as $data) {
                    $count = \App\OwnerLog::where('score_id', $data['SCORE_ID'])->withTrashed()->count();
                    if ($count > 0) {
                        continue;
                    }
                    $verify = \App\Verify::where('frame_number', $data['vin'])->first();
                    if (null == $verify) {
                        continue;
                    }
                    $data['title'] = '车主奖励';
                    $data['generate_way'] = 1;
                    $data['verify_id'] = $verify->id;
                    \App\Helpers\Helper::updateLog($verify->uid, $data);
                }
            } else {
                if ($result) {
                    $this->info($result['ret']);
                }
                return false;
            }
        }
    }
}
