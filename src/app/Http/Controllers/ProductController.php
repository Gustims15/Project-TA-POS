<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function list(): JsonResponse
    {
        $products = Product::query()
            ->with([
                'category',
                'sizes' => function ($query): void {
                    $query->where('is_active', true)
                        ->orderByDesc('is_default')
                        ->orderBy('id');
                },
            ])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'string'],

            'sizes' => ['required', 'array', 'min:1'],
            'sizes.*.name' => ['required', 'string', 'max:50'],
            'sizes.*.price' => ['required', 'integer', 'min:0'],
            'sizes.*.is_default' => ['nullable', 'boolean'],
        ]);

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'stock' => $validated['stock'],
            'image' => $validated['image'] ?? null,
            'is_active' => true,
        ]);

        foreach ($validated['sizes'] as $index => $size) {
            $product->sizes()->create([
                'name' => $size['name'],
                'price' => $size['price'],
                'is_default' => $size['is_default'] ?? $index === 0,
                'is_active' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan.',
            'data' => $product->load('category', 'sizes'),
        ]);
    }
}