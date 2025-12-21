<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Category;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $sortField = $request->input('sort_field', 'sequence');
        $sortDirection = $request->input('sort_direction', 'asc');

        $query->orderBy($sortField, $sortDirection);

        return Inertia::render('Admin/Products/Index', [
            'products' => $query->get(),
            'filters' => $request->only(['search', 'category', 'sort_field', 'sort_direction']),
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        $maxSequence = Product::max('sequence');
        $nextSequence = $maxSequence ? $maxSequence + 1 : 1;

        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::orderBy('name')->get(),
            'nextSequence' => $nextSequence
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sequence' => 'nullable|integer',
            'is_bestseller' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ]);

        // Inertia sends files as array, ensure key exists
        if ($request->hasFile('gallery_images')) {
            $validated['gallery_images'] = $request->file('gallery_images');
        }

        $this->productService->create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product->load('images'),
            'categories' => Category::orderBy('name')->get()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sequence' => 'nullable|integer',
            'is_bestseller' => 'boolean',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'deleted_images' => 'nullable|array'
        ]);

        if ($request->hasFile('gallery_images')) {
            $validated['gallery_images'] = $request->file('gallery_images');
        }

        $this->productService->update($product, $validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
