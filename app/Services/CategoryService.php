<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    public function getAll()
    {
        return Category::orderBy('sequence')->orderBy('name')->get();
    }

    public function getNextSequence()
    {
        return Category::max('sequence') + 1;
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('categories');
        }
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        if (isset($data['image'])) {
            if ($category->image_path) {
                Storage::delete($category->image_path);
            }
            $data['image_path'] = $data['image']->store('categories');
        }
        if (empty($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {
        if ($category->image_path) {
            Storage::delete($category->image_path);
        }
        return $category->delete();
    }
}
