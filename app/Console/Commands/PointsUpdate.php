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
        $frame_number = 'LVZA43F98EC554848';//车架号
        $id_card = '61052519905100828';//身份证号
        $options = [
            'frame_number'=>$frame_number,
            'id_card'=>$id_card,
            'Start_date'=>date('Y-m-d', strtotime('-1000 days')),
            'End_date'=>date('Y-m-d', strtotime('+1 days')),
        ];
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
        $options = [
            'in'=>json_encode($options),
        ];
        var_dump($client->__getTypes());
        $response = $client->__soapCall("queryPartsInfo", array($options));
        $result = json_decode($response->out,true);
        var_dump($result);
        return;
        $member_verify = DB::table('discuz_common_member_verify')->where('verify1',1)->get();
        foreach($member_verify as $row){
            $profile = DB::table('discuz_common_member_profile')->where('uid',$row->uid)->get();

            $frame_number = $profile->field1;//车架号
            $id_card = $profile->field3;//身份证号
            $options = [
                'frame_number'=>$frame_number,
                'id_card'=>$id_card,
            ];
            $client = new \SoapClient("http://interface.dfsk.com.cn/infodms_interface_hy/services/HY02SOAP?wsdl");
            $options = [
                'in'=>json_encode($options),
            ];
            $response = $client->__soapCall("Hy02", array($options));
            $result = json_decode($response->out,true);
            if($result['ret'] == 0){
                foreach ($result['data'] as $data){
                    //reason, point, spent_at, $dealer
                }
            }
        }
    }
}
