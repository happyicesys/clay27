<?php

namespace App\Http\Controllers;

use App\Services\BannerService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopController extends Controller
{
    protected $bannerService;
    protected $productService;

    public function __construct(BannerService $bannerService, ProductService $productService)
    {
        $this->bannerService = $bannerService;
        $this->productService = $productService;
    }

    public function welcome()
    {
        $banners = $this->bannerService->getAll()->where('is_active', true);
        $categories = \App\Models\Category::where('is_active', true)->orderBy('sequence')->orderBy('name')->get();

        // Use bestsellers first, then latest
        $products = \App\Models\Product::where('is_active', true)
            ->orderBy('is_bestseller', 'desc')
            ->orderBy('sequence')
            ->latest()
            ->take(8)
            ->get();

        return Inertia::render('Welcome', [
            'banners' => $banners->values(),
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function index(Request $request)
    {
        $categorySlug = $request->input('category');

        $query = \App\Models\Product::where('is_active', true)->orderBy('sequence')->latest();

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $products = $query->get();
        $categories = \App\Models\Category::where('is_active', true)->orderBy('sequence')->orderBy('name')->get();

        return Inertia::render('Shop/Index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $categorySlug,
        ]);
    }

    public function show($slug)
    {
        $product = \App\Models\Product::with(['images', 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products (same category)
        $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return Inertia::render('Shop/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
