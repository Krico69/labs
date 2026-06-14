<?php

namespace App\Http\Controllers;

use App\Services\ExternalTaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    public function __construct(
        protected ExternalTaskService $service
    ) {}

    public function posts(): JsonResponse
    {
        $posts = $this->service->getPosts();

        if (empty($posts)) {
            return response()->json(['message' => 'Failed to fetch posts'], 500);
        }

        return response()->json($posts);
    }

    public function show(int $id): JsonResponse
    {
        $post = $this->service->getPostById($id);

        if (empty($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'  => 'required|string',
            'body'   => 'required|string',
            'userId' => 'nullable|integer',
        ]);

        $post = $this->service->createPost($validated);

        if (empty($post)) {
            return response()->json(['message' => 'Failed to create post'], 500);
        }

        return response()->json($post, 201);
    }
}