<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RegisterMembers extends Command
{
  /**
  * The name and signature of the console command.
  *
  * @var string
  */
  protected $signature = 'members:register {m?} {n?}';

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
    $m =  null == $this->argument('m') ? 0 :  $this->argument('m');
    $n =  null == $this->argument('n') ? 1000 :  $this->argument('n');
    $file = file_get_contents(storage_path('crm.csv'));
    $members = explode("\n",$file);
    foreach ($members as $key=>$member) {
      if( $key < $m || $key > $n){
        continue;
      }
      $_member = explode(",", $member);
      $return = file_get_contents('http://club.dffengguang.com.cn//openapi/userinfo?Vin='.$_member[0].'&id_card='.urlencode($_member[1]));
      $this->info($return);
    }
  }
}
