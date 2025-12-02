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
        $products = $this->productService->getAll()->where('is_active', true)->take(8);

        return Inertia::render('Welcome', [
            'banners' => $banners->values(),
            'products' => $products->values(),
        ]);
    }

    public function index()
    {
        $products = $this->productService->getAll()->where('is_active', true);
        return Inertia::render('Shop/Index', [
            'products' => $products->values(),
        ]);
    }

    public function show($slug)
    {
        $product = \App\Models\Product::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return Inertia::render('Shop/Show', [
            'product' => $product,
        ]);
    }
}
