<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunBatchFile extends Command
{
    protected $signature = 'script:run';
    protected $description = 'Run the specified PHP script';

    public function handle()
    {
        // Define the path to the PHP script
        $scriptPath = 'C:\\laragon\\www\\table_testing\\text.php';

        // Execute the PHP script
        $output = shell_exec("php \"$scriptPath\"");
    
        // Output the result to the console
        $this->info($output);
    }
}
