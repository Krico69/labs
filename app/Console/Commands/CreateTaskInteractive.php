<?php

namespace App\Console\Commands;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Console\Command;

class CreateTaskInteractive extends Command
{
    protected $signature = 'tasks:create-interactive';

    protected $description = 'Інтерактивне створення задачі';

    public function handle(): void
{
    $this->info('=== Створення нової задачі ===');

    $title = $this->ask('Введіть назву задачі');
    $title = preg_replace('/[^\x20-\x7E\xC0-\xFF]/u', '', $title); // 👈 одразу після ask

    $description = $this->ask('Короткий опис (необов\'язково)');

    $dueDate = $this->ask('Дата дедлайну (у форматі YYYY-MM-DD)');

    $status = $this->choice(
        'Оберіть статус',
        ['new', 'in_progress', 'done'],
        0
    );

    $assigneeId = $this->ask('ID виконавця (або залиште порожнім)');

    $this->info('--- Дані задачі ---');
    $this->info("Назва: {$title}");
    $this->info("Опис: {$description}");
    $this->info("Дедлайн: {$dueDate}");
    $this->info("Статус: {$status}");
    $this->info("Виконавець ID: " . ($assigneeId ?: '—'));

    if (!$this->confirm('Створити цю задачу?', true)) {
        $this->warn('Створення скасовано.');
        return;
    }

    $task = Task::create([
        'title'       => $title,
        'description' => $description,
        'status'      => $status,
        'project_id'  => 1,
        'author_id'   => 1,
        'assigned_to' => $assigneeId ?: null,
        'due_date'    => $dueDate ?: null,
    ]);

    event(new TaskCreated($task));

    $this->info("Задача '{$task->title}' створена з ID: {$task->id}");
}
}