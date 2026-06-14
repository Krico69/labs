<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class GenerateTaskReport extends Command
{
    protected $signature = 'tasks:report {--project_id= : ID проєкту для фільтрації}';

    protected $description = 'Генерує звіт по задачах';

    public function handle(): void
    {
        $projectId = $this->option('project_id');

        if ($projectId) {
            $tasks = Task::with(['project'])
                        ->where('project_id', $projectId)
                        ->get();
            $this->info("Задачі для проєкту #{$projectId}:");
        } else {
            $tasks = Task::with(['project'])->get();
            $this->info('Всі задачі в системі:');
        }

        if ($tasks->isEmpty()) {
            $this->warn('Задач не знайдено!');
            return;
        }

        $rows = $tasks->map(fn($task) => [
            $task->id,
            $task->title,
            $task->status,
            $task->due_date ?? '—',
            $task->project->name ?? '—',
        ])->toArray();

        $this->table(
            ['ID', 'Назва', 'Статус', 'Дедлайн', 'Проєкт'],
            $rows
        );
    }
}