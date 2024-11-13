<?php

namespace App\Services;

use App\Models\BackgroundJob;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class BackgroundRunner
{
    protected $maxRetries;

    public function __construct($maxRetries = 3)
    {
        $this->maxRetries = $maxRetries;
    }

    public function executeJob($class, $method, $parameters = [], int $priority = 1, $delay = 0)
    {
        // Check if class and method are approved
        if (!$this->isApprovedClass($class, $method)) {
            Log::channel("backround_jobs_errors")->error("Unauthorized class or method: $class::$method");
            throw new Exception("Unauthorized class or method: $class::$method");
        }
        //Log::info("Before saving to BackgroundJob: $class::$method");
        // Create a job record in the database
        $job = BackgroundJob::create([
            'class' => $class,
            'method' => $method,
            'parameters' => json_encode($parameters),
            'status' => 'pending',
            'retry_count' => 0,
            'priority' => $priority,
            'scheduled_at' => now()->addSeconds($delay)
        ]);

        //Log::info("After saving to BackgroundJob: $class::$method", ["job" => $job]);

        // Dispatch job in background based on OS
        $this->runInBackground($class, $method, $parameters, $job->id, $delay);
    }

    public function processPendingJobs()
    {
        // Retrieve pending jobs ordered by priority and schedule date
        $jobs = BackgroundJob::where('status', 'pending')
            ->orderBy('priority', 'asc')
            ->orderBy('scheduled_at', 'asc')
            ->get();

        foreach ($jobs as $job) {
            $this->handleJob($job->class, $job->method, json_decode($job->parameters, true), $job->id);
        }
    }

    protected function runInBackground($class, $method, $parameters, $jobId, $delay)
    {
        $cmd = "php artisan job:run {$class} {$method} " . escapeshellarg(json_encode($parameters)) . " {$jobId}";

        if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
            //Log::info("Executing for windows");
            pclose(popen("start /B $cmd", "r"));
        } else {
            // Log::info("Executing for Linux");
            //exec("$cmd > /dev/null &");
            $artisanPath = base_path('artisan');
            $cmd = "/usr/bin/php $artisanPath job:run {$class} {$method} " . escapeshellarg(json_encode($parameters)) . " {$jobId}";
            exec("$cmd > /var/www/html/job-runner/storage/logs/cmd-error.log 2>&1 &");
        }
    }

    public function handleJob($class, $method, $parameters, $jobId)
    {
        $job = BackgroundJob::find($jobId);

        if (!$job) {
            Log::channel("background_jobs_errors")->error("Job with ID {$jobId} not found.");
            return;
        }

        Log::info('Before job execution: ' . $job->status);
        if (!$job || $job->status === 'canceled') {
            return;
        }

        try {
            $instance  = app()->make($class);
            $job->update(['status' => 'running']);
            //$instance = new $class;
            call_user_func_array([$instance, $method], $parameters);
            $job->update(['status' => 'completed']);
            Log::info('after job execution: ' . $job->status);
        } catch (Exception $e) {
            $this->handleError($job, $e);
        }
    }

    protected function handleError($job, Exception $e)
    {
        $job->update(['status' => 'failed', 'retry_count' => $job->retry_count + 1]);
        Log::channel("background_jobs_errors")->error("Job failed: {$e->getMessage()}");

        if ($job->retry_count < $this->maxRetries) {
            $this->runInBackground($job->class, $job->method, json_decode($job->parameters, true), $job->id, 5); // retry after 5s
        }
    }

    protected function isApprovedClass($class, $method)
    {
        $approvedClasses = [

            'App\\Jobs\\TestJob', // Add TestJob for testing
        ];

        return in_array($class, $approvedClasses) && method_exists($class, $method);
    }
}
