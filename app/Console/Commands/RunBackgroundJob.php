<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BackgroundRunner;

class RunBackgroundJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:run {class} {method} {parameters} {jobId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a specific background job';

    protected $backgroundRunner;

    public function __construct(BackgroundRunner $backgroundRunner)
    {
        parent::__construct();
        $this->backgroundRunner = $backgroundRunner;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $class = $this->argument('class');
        $method = $this->argument('method');
        $parameters = json_decode($this->argument('parameters'), true);
        $jobId = $this->argument('jobId');

        // Run the job using the BackgroundRunner service
        $this->backgroundRunner->handleJob($class, $method, $parameters, $jobId);

        return Command::SUCCESS;
    }
}
