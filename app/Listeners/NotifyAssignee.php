<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Support\Facades\Log;

class NotifyAssignee
{
    public function handle(TaskCreated $event): void
    {
        $task = $event->task;

        if ($task->assigned_to) {
            Log::info('Notifying assignee about new task', [
                'task_id'     => $task->id,
                'task_title'  => $task->title,
                'assignee_id' => $task->assigned_to,
            ]);
        } else {
            Log::info('Task created with no assignee', [
                'task_id'    => $task->id,
                'task_title' => $task->title,
            ]);
        }
    }
}