<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ObtainCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'obtain:coupons';

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
        $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY07?wsdl");

        $response = $client->__soapCall("getElectronicVouchersUseInfo", []);
        $result = json_decode($response->getElectronicVouchersUseInfoReturn,true);

        if($result['ret'] == 0 && isset($result['data']) && is_array($result['data'])){
            foreach($result['data'] as $data){
                $coupon = \App\Coupon::where('code', $data['coup_num'])->first();
                if( null != $coupon ){
                    $coupon->status = 2;
                    $coupon->spent_at = $data['use_date'];
                    $coupon->spent_frame_number = $data['hyid'];
                    $coupon->save();
                }
            }
        }

    }
}
