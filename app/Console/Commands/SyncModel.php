<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncModel extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'sync:model {n?}';

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
        $n =  null == $this->argument('n') ? 1 :  $this->argument('n');
        //$count = \App\Verify::where('status','>=',0)->count();
        //$total = ceil($count/1000);
        $verifies = \App\Verify::where('status','>=',0)
            ->where('created_at','>=','2018-03-01')
            //->where('id','375099')
            ->skip(($n-1)*10000)->take(10000)->get();
        foreach($verifies as $verify){
            $this->info($verify->id);
            $options = [
                'frame_number'=>substr($verify->frame_number,-8),
                'id_card'=>$verify->id_card,
                'register_date'=>date('Y-m-d H:i:s'),
                'type'=>'1',
            ];
            try{
                $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY01SOAP?wsdl");
                $options = [
                    'in'=>json_encode($options),
                ];
                $response = $client->__soapCall("Hy01", array($options));
                $result = json_decode($response->out,true);
            }catch (\SoapFault $fault) {
                $result = false;
                $this->info('网络错误');
            }
            
            if( $result && $result['ret'] == 0){
                $model = \App\Helpers\Helper::replaceCarModel($result['modelCode']);
                $this->info($verify->id.','.$verify->frame_number.','.$model.','.$verify->model_code.','.$result['modelCode']);
                if($model != $verify->model_code){
                    $credit1 = \App\Helpers\Helper::getCreditsFromCarModel($model);
                    $credit2 = \App\Helpers\Helper::getCreditsFromCarModel($verify->model_code);
                    $verify->model_code = $model;
                    $verify->save();

                    $user_count = \App\UserCount::where('uid',$verify->uid)->first();
                    if( $user_count != null ){
                        $user_count->extcredits1 += $credit2 - $credits1;
                        //$user_count->extcredits4 += $credits4;
                        //更新积分
                        \DB::table('discuz_common_member_count')->where('uid',$verify->uid)->update([
                            'extcredits1' => $user_count->extcredits1,
                            //'extcredits4' => $user_count->extcredits4,
                        ]);
                        $this->info($verify->id.','.$model.','.$verify->model_code.','.$result['modelCode'].',更改前积分:'.$credit1.',更改后:'.$credit2.',最终积分:'. $user_count->extcredits1);
                    }
                    
                }
            }
        }
        if(null != $verifies || count($verifies) != 0){
            $this->call('sync:model', ['n'=>$n+1]);
        }
    }
}
