<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Comment::with(['task', 'user'])->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string|max:1000',
        ]);

        $validated['user_id'] = $request->user()?->id ?? 1;

        $comment = Comment::create($validated);
        return response()->json($comment, 201);
    }

    public function show(Comment $comment): JsonResponse
    {
        return response()->json($comment->load(['task', 'user']));
    }

    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update($validated);
        return response()->json($comment);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}