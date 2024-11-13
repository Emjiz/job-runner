<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackgroundRunner;

class RunPendingJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:run-pending-jobs';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Running pending jobs in the background';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $bg = new BackgroundRunner();
        $bg->processPendingJobs();
    }
}
