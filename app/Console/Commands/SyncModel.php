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
        $verifies = \App\Verify::where('status','>=',0)->skip(($n-1)*10000)->take(10000)->get();
        foreach($verifies as $verify){
            $options = [
                'frame_number'=>substr($verify->frame_number,-8),
                'id_card'=>$verify->id_card,
                'register_date'=>date('Y-m-d H:i:s'),
                'type'=>'1',
            ];

            $client = new \SoapClient("http://124.162.32.6:8081/infodms_interface_hy/services/HY01SOAP?wsdl");
            $options = [
                'in'=>json_encode($options),
            ];
            $response = $client->__soapCall("Hy01", array($options));
            $result = json_decode($response->out,true);
            if( $result && $result['ret'] == 0){
                $model = \App\Helpers\Helper::replaceCarModel($result['modelCode']);
                if($model != $verify->model_code){
                    $this->info($verify->id.','.$model.','.$verify->model_code.','.$result['modelCode']);
                    $verify->model_code = $model;
                    $verify->save();
                }
            }
        }
        if(null != $verifies){
            $this->call('sync:model', ['n'=>$n+1]);
        }
    }
}
