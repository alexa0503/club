<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //
    }
}
