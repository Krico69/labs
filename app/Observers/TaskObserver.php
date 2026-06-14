<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    public function created(Task $task): void
    {
        Log::info('Task created', [
            'id'    => $task->id,
            'title' => $task->title,
        ]);
    }

    public function updated(Task $task): void
    {
        Log::info('Task updated', [
            'id'      => $task->id,
            'title'   => $task->title,
            'changes' => $task->getChanges(),
        ]);
    }

    public function deleted(Task $task): void
    {
        Log::warning('Task deleted', [
            'id'    => $task->id,
            'title' => $task->title,
        ]);
    }
}