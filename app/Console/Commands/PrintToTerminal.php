<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PrintToTerminal extends Command
{
    // Command signature
    protected $signature = 'terminal:print-message';

    // Command description
    protected $description = 'Print a custom message to the terminal';

    public function handle()
    {
        // Print a message to the terminal
        $this->info('Hello, this is a message printed by the Laravel Task Scheduler!');
        
        // You can also use $this->line() for a plain output
        $this->line('This is another line of text.');

        
    }
}
