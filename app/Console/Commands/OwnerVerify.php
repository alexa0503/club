<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Helpers\DiscuzHelper;

class OwnerVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owner:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'verify owner';

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
        //return;
        $frame_number = 'LVZA53P94GC578465';
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY07?wsdl");
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
            ])
        ];
        var_dump($client->__getFunctions());
        $response = $client->__soapCall("getElectronicVouchersUseInfo",[]);
        var_dump($response);
        return;
        $frame_number = 'LVZA53P94GC578465';
        $id_card = '450305197012070019';
        $options = [
            'frame_number'=>$frame_number,
            'id_card'=>$id_card,
            'register_date'=>date('Y-m-d H:i:s'),
            'type'=>'1',
        ];
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY01SOAP?wsdl");
        var_dump($client->__getFunctions());
        $options = [
            'in'=>json_encode($options),
        ];
        $response = $client->__soapCall("Hy01", array($options));
        $result = json_decode($response->out,true);
        var_dump($result);



        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY02SOAP?wsdl");
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
                'id_card'=>$id_card,
                'Start_date'=>'2000-01-01',
                'End_date'=>date('Y-m-d'),
            ]),
        ];
        $response = $client->__soapCall("queryPartsInfo", array($options));
        $result = json_decode($response->out,true);
        var_dump($result);


        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY03?wsdl");
        $options = [
            'json'=>json_encode([
                'vin'=>$frame_number,
                'member_level'=>"黄金卡",
                'multiple'=>"1.3"
            ])
        ];
        $response = $client->__soapCall("addMemberLevelInfo", array($options));
        //$result = json_decode($response->addMemberLevelInfoReturn,true);
        var_dump($response);


        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY04?wsdl");
        $options = [
            'json'=>json_encode([
                'vin'=>$frame_number,
                'coup_num'=>date('YmdHis'),
                'face_amount'=>'200',
                'valid_date'=>'2018-09-01',
            ])
        ];
        $response = $client->__soapCall("addElectronicVouchersInfo", array($options));
        $result = json_decode($response->addElectronicVouchersInfoReturn,true);
        var_dump($response);


        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY05SOAP?wsdl");
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
            ])
        ];
        $response = $client->__soapCall("CancelOrderAccount", array($options));
        var_dump($response);
        //$result = json_decode($response->out,true);


        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY06SOAP?wsdl");
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
            ])
        ];
        $response = $client->__soapCall("QueryVehicleReturnInfo", array($options));
        var_dump($response);
        //$result = json_decode($response->out,true);


        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY07?wsdl");
        $options = [
            'in'=>json_encode([
                'frame_number'=>$frame_number,
            ])
        ];
        //var_dump($client->__getFunctions());
        $response = $client->__soapCall("getElectronicVouchersUseInfo", array($options));
        var_dump($response);
        //$result = json_decode($response->getElectronicVouchersUseInfoReturn,true);


        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY08SOAP?wsdl");
        $options = [
        ];

        $response = $client->__soapCall("QueryModelCodeInfo", array($options));

        $result = json_decode($response->out,true);
        var_dump($response);
        return;
    }
}
