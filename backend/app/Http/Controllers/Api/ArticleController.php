<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\NewsletterController;

class ArticleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['category', 'author'])
            ->published()
            ->recent();

        if ($request->category) {
            $query->byCategory($request->category);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $articles = $query->paginate($request->per_page ?? 12);

        return response()->json([
            'data' => $articles->items(),
            'meta' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        ]);
    }

    public function recent(): JsonResponse
    {
        $articles = Article::with(['category', 'author'])
            ->published()
            ->recent()
            ->limit(6)
            ->get();

        return response()->json($articles);
    }

    public function show(string $slug): JsonResponse
    {
        $article = Article::with(['category', 'author'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json($article);
    }

    public function related(string $slug): JsonResponse
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        $related = Article::with(['category', 'author'])
            ->published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return response()->json($related);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:users,id',
            'published_date' => 'required|date',
            'is_published' => 'boolean',
            'read_time' => 'integer|min:1|max:30',
        ]);

        $article = Article::create($validated);

        // Send newsletter notification if article is published
        if ($article->is_published) {
            $newsletterController = new NewsletterController();
            $newsletterController->notifyNewArticle($article->load(['category', 'author']));
        }

        return response()->json($article->load(['category', 'author']), 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'excerpt' => 'sometimes|required|string|max:500',
            'content' => 'sometimes|required|string',
            'featured_image_url' => 'nullable|url',
            'category_id' => 'sometimes|required|exists:categories,id',
            'author_id' => 'sometimes|required|exists:users,id',
            'published_date' => 'sometimes|required|date',
            'is_published' => 'boolean',
            'read_time' => 'sometimes|integer|min:1|max:30',
        ]);

        $article->update($validated);

        return response()->json($article->load(['category', 'author']));
    }

    public function destroy(string $slug): Response
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $article->delete();

        return response()->noContent();
    }
}
