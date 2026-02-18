<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FAQController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = FAQ::active()->ordered();

        if ($request->category) {
            $query->byCategory($request->category);
        }

        $faqs = $query->get();

        $grouped = $faqs->groupBy('category');

        return response()->json($grouped);
    }

    public function categories(): JsonResponse
    {
        $categories = FAQ::active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return response()->json($categories);
    }

    public function show(string $id): JsonResponse
    {
        $faq = FAQ::findOrFail($id);

        return response()->json($faq);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|max:100',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $faq = FAQ::create($validated);

        return response()->json($faq, 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $faq = FAQ::findOrFail($id);

        $validated = $request->validate([
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string',
            'category' => 'sometimes|required|string|max:100',
            'sort_order' => 'sometimes|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $faq->update($validated);

        return response()->json($faq);
    }

    public function destroy(string $id): JsonResponse
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();

        return response()->json(null, 204);
    }
}
