<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalTaskService
{
    protected string $baseUrl = 'https://jsonplaceholder.typicode.com';

    public function getPosts(): array
    {
        $start = microtime(true);

        $response = Http::get("{$this->baseUrl}/posts");

        $duration = round((microtime(true) - $start) * 1000, 2);

        if ($response->successful()) {
            Log::info('GET /posts successful', [
                'status'   => $response->status(),
                'duration' => "{$duration}ms",
            ]);
            return $response->json();
        }

        Log::error('GET /posts failed', [
            'status' => $response->status(),
        ]);

        return [];
    }

    public function getPostById(int $id): array
    {
        $start = microtime(true);

        $response = Http::get("{$this->baseUrl}/posts/{$id}");

        $duration = round((microtime(true) - $start) * 1000, 2);

        if ($response->successful()) {
            Log::info("GET /posts/{$id} successful", [
                'status'   => $response->status(),
                'duration' => "{$duration}ms",
            ]);
            return $response->json();
        }

        Log::error("GET /posts/{$id} failed", [
            'status' => $response->status(),
        ]);

        return [];
    }

    public function createPost(array $data): array
    {
        $start = microtime(true);

        $response = Http::post("{$this->baseUrl}/posts", [
            'title'  => $data['title'],
            'body'   => $data['body'],
            'userId' => $data['userId'] ?? 1,
        ]);

        $duration = round((microtime(true) - $start) * 1000, 2);

        if ($response->successful()) {
            Log::info('POST /posts successful', [
                'status'   => $response->status(),
                'duration' => "{$duration}ms",
                'data'     => $response->json(),
            ]);
            return $response->json();
        }

        Log::error('POST /posts failed', [
            'status' => $response->status(),
        ]);

        return [];
    }
}