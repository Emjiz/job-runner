<?php

use App\Services\BackgroundRunner;

if (!function_exists('runBackgroundJob')) {
    /**
     * Run a background job with specified parameters.
     *
     * @param string $class The fully qualified class name of the job.
     * @param string $method The method to be executed on the job class.
     * @param array $parameters The parameters to be passed to the method.
     * @param int $priority The priority of the job (default is 3).
     * @param int $delay The delay before running the job, in seconds (default is 0).
     * 
     * @return void
     */

    function runBackgroundJob(string $class, string $method, array $parameters = [], int $retries = 3, int $priority = 3, int $delay = 0)
    {
        $runner = new BackgroundRunner($retries);
        $runner->executeJob($class, $method, $parameters, $retries, $priority, $delay);
    }
}
