<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function getAll()
    {
        return Product::with('category')->orderBy('sequence')->latest()->get();
    }

    public function create(array $data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('products');
        }

        $product = Product::create($data);

        if (isset($data['gallery_images'])) {
            foreach ($data['gallery_images'] as $image) {
                $path = $image->store('product_gallery');
                $product->images()->create([
                    'image_path' => $path,
                    'sequence' => 0 // Default sequence
                ]);
            }
        }

        return $product;
    }

    public function update(Product $product, array $data)
    {
        if (isset($data['name']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        if (isset($data['image'])) {
            if ($product->image_path) {
                Storage::delete($product->image_path);
            }
            $data['image_path'] = $data['image']->store('products');
        }

        $product->update($data);

        if (isset($data['gallery_images'])) {
            foreach ($data['gallery_images'] as $image) {
                $path = $image->store('product_gallery');
                $product->images()->create([
                    'image_path' => $path,
                    'sequence' => 0
                ]);
            }
        }

        // Remove deleted images if any IDs passed (basic implementation, maybe omitted for now unless UI supports it)
        if (isset($data['deleted_images'])) {
            foreach ($data['deleted_images'] as $imageId) {
                $img = $product->images()->find($imageId);
                if ($img) {
                    Storage::delete($img->image_path);
                    $img->delete();
                }
            }
        }

        return $product;
    }

    public function delete(Product $product)
    {
        if ($product->image_path) {
            Storage::delete($product->image_path);
        }
        foreach ($product->images as $img) {
            Storage::delete($img->image_path);
        }
        return $product->delete();
    }
}
