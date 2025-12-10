<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sitemap;
use App\Models\SitemapCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemaps = Sitemap::with('category')->orderBy('order')->orderBy('title_th')->get();
        return Inertia::render('Admin/Sitemaps/Index', [
            'sitemaps' => $sitemaps
        ]);
    }

    public function create()
    {
        $categories = SitemapCategory::where('status', true)->orderBy('order')->get();
        return Inertia::render('Admin/Sitemaps/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sitemap_category_id' => 'required', // Allow logic check later
            'title_th' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'link' => 'required|string|max:500',
            'order' => 'integer',
            'status' => 'boolean',
        ]);

        // Check if category ID is numeric (existing) or string (new)
        if (is_numeric($request->sitemap_category_id)) {
            $validated['sitemap_category_id'] = $request->sitemap_category_id;
        } else {
            // Create new category
            $category = SitemapCategory::create([
                'name_th' => $request->sitemap_category_id,
                'name_en' => $request->sitemap_category_id, // Default to same
                'order' => SitemapCategory::max('order') + 1,
                'status' => true,
            ]);
            $validated['sitemap_category_id'] = $category->id;
        }

        Sitemap::create($validated);

        return redirect()->route('admin.sitemaps.index')->with('success', 'Sitemap link created successfully.');
    }

    public function edit(Sitemap $sitemap)
    {
        $categories = SitemapCategory::where('status', true)->orderBy('order')->get();
        return Inertia::render('Admin/Sitemaps/Edit', [
            'sitemap' => $sitemap,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Sitemap $sitemap)
    {
        $validated = $request->validate([
            'sitemap_category_id' => 'required',
            'title_th' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'link' => 'required|string|max:500',
            'order' => 'integer',
            'status' => 'boolean',
        ]);

        if (is_numeric($request->sitemap_category_id)) {
            $validated['sitemap_category_id'] = $request->sitemap_category_id;
        } else {
            // Create new category
            $category = SitemapCategory::create([
                'name_th' => $request->sitemap_category_id,
                'name_en' => $request->sitemap_category_id,
                'order' => SitemapCategory::max('order') + 1,
                'status' => true,
            ]);
            $validated['sitemap_category_id'] = $category->id;
        }

        $sitemap->update($validated);

        return redirect()->route('admin.sitemaps.index')->with('success', 'Sitemap link updated successfully.');
    }

    public function destroy(Sitemap $sitemap)
    {
        $sitemap->delete();
        return redirect()->back()->with('success', 'Sitemap link deleted successfully.');
    }
}
