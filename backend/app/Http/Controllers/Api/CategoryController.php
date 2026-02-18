<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::active()
            ->ordered()
            ->withCount('publishedArticles')
            ->get();

        return response()->json($categories);
    }

    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)
            ->with(['publishedArticles' => function ($query) {
                $query->recent()->paginate(12);
            }])
            ->firstOrFail();

        return response()->json($category);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $category = Category::create($validated);

        return response()->json($category, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'sometimes|integer|min:0',
        ]);

        $category->update($validated);

        return response()->json($category);
    }

    public function destroy(string $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        
        if ($category->articles()->count() > 0) {
            return response()->json([
                'error' => 'Cannot delete category with associated articles'
            ], 422);
        }

        $category->delete();

        return response()->json(null, 204);
    }
}
