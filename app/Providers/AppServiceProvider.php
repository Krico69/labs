<?php

namespace App\Providers;

use App\Models\Task;
use App\Observers\TaskObserver;
use App\Events\TaskCreated;
use App\Listeners\NotifyAssignee;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Task::observe(TaskObserver::class);

        Event::listen(
            TaskCreated::class,
            NotifyAssignee::class,
        );
    }
}