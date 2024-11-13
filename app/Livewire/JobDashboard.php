<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BackgroundJob;
use Illuminate\Support\Facades\Log;

class JobDashboard extends Component
{
    public $jobs;
    public $refreshInterval = 5;
    public $head = "Job Dashboard";

    protected $listeners = ['cancelJob', 'retryJob'];

    public function mount()
    {
        $this->loadJobs();
    }

    public function loadJobs()
    {
        $this->jobs = BackgroundJob::orderBy('priority', 'desc')->orderBy('scheduled_at')->get();
    }

    public function cancelJob($jobId)
    {
        // Add cancel job logic here
        $job = BackgroundJob::findOrFail($jobId);
        $job->status = "canceled";
        $job->save();
        $this->loadJobs();
    }

    public function retryJob($jobId)
    {
        // Add retry job logic here
    }



    public function render()
    {
        return view('livewire.job-dashboard')->layout('layouts.app');;
    }
}
