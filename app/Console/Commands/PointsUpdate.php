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
      $count = \App\Verify::where('status','>=',0)->count();
      $n = ceil($count/100);
      for ($i=0; $i < $n; $i++) {
        $verifies = \App\Verify::where('status','>=',0)->skip($i*100)->take(100)->get();
        foreach($verifies as $verify){
          $this->info($i.','.$verify->id);
          \App\Helpers\Helper::pointsUpdate($verify);
        }
      }

    }
}
