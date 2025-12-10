<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SitemapCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SitemapCategoryController extends Controller
{
    public function index()
    {
        $categories = SitemapCategory::orderBy('order')->orderBy('name_th')->get();
        return Inertia::render('Admin/Sitemaps/Categories/Index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Sitemaps/Categories/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'order' => 'integer',
            'status' => 'boolean',
        ]);

        SitemapCategory::create($validated);

        return redirect()->route('admin.sitemap-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(SitemapCategory $sitemapCategory)
    {
        return Inertia::render('Admin/Sitemaps/Categories/Edit', [
            'category' => $sitemapCategory
        ]);
    }

    public function update(Request $request, SitemapCategory $sitemapCategory)
    {
        $validated = $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'order' => 'integer',
            'status' => 'boolean',
        ]);

        $sitemapCategory->update($validated);

        return redirect()->route('admin.sitemap-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(SitemapCategory $sitemapCategory)
    {
        $sitemapCategory->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
