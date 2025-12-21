<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BannerController extends Controller
{
    protected $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index()
    {
        return Inertia::render('Admin/Banners/Index', [
            'banners' => $this->bannerService->getAll()
        ]);
    }

    public function create()
    {
        $existingPositions = Banner::distinct()->pluck('position')->toArray();
        return Inertia::render('Admin/Banners/Create', [
            'existingPositions' => $existingPositions
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:2048',
            'link_url' => 'nullable|url',
            'position' => 'string|in:main,footer,workshop',
            'is_active' => 'boolean'
        ]);

        if (Banner::where('position', $validated['position'])->exists()) {
            return back()->withErrors(['position' => 'A banner with this position already exists.']);
        }

        $this->bannerService->create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        $existingPositions = Banner::distinct()->pluck('position')->toArray();
        return Inertia::render('Admin/Banners/Edit', [
            'banner' => $banner,
            'existingPositions' => $existingPositions
        ]);
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link_url' => 'nullable|url',
            'position' => 'string|in:main,footer,workshop',
            'is_active' => 'boolean'
        ]);

        if (isset($validated['position']) && Banner::where('position', $validated['position'])->where('id', '!=', $banner->id)->exists()) {
            return back()->withErrors(['position' => 'A banner with this position already exists.']);
        }

        $this->bannerService->update($banner, $validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $this->bannerService->delete($banner);
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
