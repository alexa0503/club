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
    protected $signature = 'points:update {n?}';

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

        $n =  null == $this->argument('n') ? 0 :  $this->argument('n');
        for ($i=0; $i < 10 ; $i++) {
            $start = $i*1000 + $n*10000;
            $verifies = \App\Verify::where('status','>=',0)->skip($start)->take(1000)->orderBy('created_at', 'DESC')->get();
            foreach($verifies as $verify){
                \App\Helpers\Helper::pointsUpdate($verify);
                $this->info('积分更新:'.$verify->id);
            }
            $this->info($start.'n:'.$n);
        }
    }
}
