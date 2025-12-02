<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function getAll()
    {
        return Product::latest()->get();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('products', 'public');
        }
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (isset($data['image'])) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $data['image']->store('products', 'public');
        }
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        return $product->delete();
    }
}
