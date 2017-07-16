<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendCoupons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:coupons';

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
        $coupons = \App\Coupon::where('status',0)->get();
        foreach($coupons as $coupon){
            $frame_number = \App\Verify::where('uid',$coupon->uid)->get()->map(function($item){
                return $item->frame_number;
            })->toArray();
            if( empty($frame_number) ){
                continue;
            }
            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY04?wsdl");
            $options = [
                'json'=>json_encode([
                    'vin'=>implode(',', $frame_number),
                    'coup_num'=>$coupon->code,
                    'face_amount'=>$coupon->value,
                    'valid_date'=>$coupon->valid_date,
                ])
            ];
            $response = $client->__soapCall("addElectronicVouchersInfo", array($options));
            $result = json_decode($response->addElectronicVouchersInfoReturn,true);
            if($result['ret'] == 0){
                $coupon->status = 1;
                $coupon->save();
            }
        }
    }
}
