<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'user Added';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $data['name'] = 'ABC';
        $data['email'] = 'abc@gmail.com';
        DB::table('test_schedules')->insert($data);

        $this->info('Success');
    }
}
