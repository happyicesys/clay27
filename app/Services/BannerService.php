<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function getAll()
    {
        return Banner::orderBy('position', 'desc')->latest()->get();
    }

    public function create(array $data)
    {
        if (isset($data['image'])) {
            $data['image_path'] = $data['image']->store('banners');
        }
        return Banner::create($data);
    }

    public function update(Banner $banner, array $data)
    {
        if (isset($data['image'])) {
            if ($banner->image_path) {
                Storage::delete($banner->image_path);
            }
            $data['image_path'] = $data['image']->store('banners');
        }
        $banner->update($data);
        return $banner;
    }

    public function delete(Banner $banner)
    {
        if ($banner->image_path) {
            Storage::delete($banner->image_path);
        }
        return $banner->delete();
    }
}
