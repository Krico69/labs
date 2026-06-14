<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Task::with(['project', 'author', 'assignee'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:new,in_progress,done',
            'project_id'  => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        $validated['author_id'] = $request->user()?->id ?? 1;

        $task = Task::create($validated);

        event(new TaskCreated($task));

        return response()->json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($task->load(['project', 'author', 'assignee', 'comments']));
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'sometimes|in:new,in_progress,done',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date'    => 'nullable|date',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}