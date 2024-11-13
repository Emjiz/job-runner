<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class TestJob
{


    protected $jobId;

    public function __construct() {}

    public function test_me($name, $surname)
    {
        // Example job logic
        // Update the job status in the database (simulating a long-running process)
        Log::info("This a test i received these two paramaters: ", ["name" => $name, "surname" => $surname]);
    }
}
