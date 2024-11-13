<div class="mt-10 text-white px-5" wire:poll.5s="loadJobs">
    <div class="text-xl font-bold uppercase">Background Job Dashboard</div>
    <table class="table-auto w-full text-left">
        <thead>
            <tr>
                <th>ID</th>
                <th>Class</th>
                <th>Method</th>
                <th>Status</th>
                <th>Exception</th>
                <th>Retries</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->class }}</td>
                    <td>{{ $job->method }}</td>
                    <td>{{ $job->status }}</td>
                    <td>{{ $job->exception ?? 'None' }}</td>
                    <td>{{ $job->retry_count }}</td>
                    <td>{{ $job->priority }}</td>
                    <td>
                        @if ($job->status === 'cancel')
                            <button wire:click="cancelJob({{ $job->id }})" class="text-red-500">Cancel</button>
                        @endif

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No jobs available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
