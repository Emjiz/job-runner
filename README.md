## Custom Background Job Runner for Laravel

### Overview

This custom background job runner executes PHP classes independently of Laravel's built-in queue system.

### Requirements

-   Make sure you [composer](https://getcomposer.org/doc/00-intro.md) and [npm](https://www.freecodecamp.org/news/node-version-manager-nvm-install-guide/) installed in your system.
-   Clone the reprository, run `composer install`, run `npm install` then `npm run dev`.
-   Create a database and add the database details to your .env file.
-   Run `php artisan migrate` then `php artisan db:seed`. This is to create a database which will be used to sign in and keep track of background jobs.

### Usage

-   Call the `runBackgroundJob` function with a class, method, and parameters: `runBackgroundJob(string $class, string $method, array $parameters = [], int $retries = 3, int $priority = 3, int $delay = 0)`.

-   Configure `retries`, `priority`, and `delay`. The parameters must be an array, the first element will be your first paramater and so on.
-   You can also run a pending jobs from the command line with `php artisan job:run-pending-jobs`. You can also setup schedules so that the command is executed in every certain interval you can seed the example in `routes/console.php`.
-   You will can view error logs in `storage/logs/background_jobs_errors.log`.

Example:

```php
runBackgroundJob(\App\Jobs\ExampleJob::class, 'handle', ['param1', 'param2'], 3, 1, 5);
```

### Dashboard

-   The dasbhoard is a simple interface using Livewire.
-   You can login using **_email_**: `admin@test.com`, **_password_**: `admin123`.
-   Here you can view jobs and their statuses, you can also Cancel pending jobs.

### Improvements

-   Since using livewire we could run `processPendingJobs` method in every polling.
