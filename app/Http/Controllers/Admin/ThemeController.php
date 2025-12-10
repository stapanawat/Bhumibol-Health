<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes = Theme::latest()->get();
        return Inertia::render('Admin/Themes/Index', [
            'themes' => $themes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Themes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'colors' => 'required|array',
            'font_family' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|max:10240', // 10MB
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
            'css_overrides' => 'nullable|string',
        ]);

        if ($request->hasFile('background_image')) {
            $path = $request->file('background_image')->store('themes/backgrounds', 'public');
            $validated['background_image'] = '/storage/' . $path;
        }

        Theme::create($validated);

        return redirect()->route('admin.themes.index')->with('success', 'Theme created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        return Inertia::render('Admin/Themes/Edit', [
            'theme' => $theme
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'colors' => 'required|array',
            'font_family' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|max:10240',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
            'css_overrides' => 'nullable|string',
        ]);

        if ($request->hasFile('background_image')) {
            // Delete old image if exists
            if ($theme->background_image) {
                $oldPath = str_replace('/storage/', '', $theme->background_image);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('background_image')->store('themes/backgrounds', 'public');
            $validated['background_image'] = '/storage/' . $path;
        }

        $theme->update($validated);

        return redirect()->route('admin.themes.index')->with('success', 'Theme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        if ($theme->background_image) {
            $oldPath = str_replace('/storage/', '', $theme->background_image);
            Storage::disk('public')->delete($oldPath);
        }

        $theme->delete();

        return redirect()->back()->with('success', 'Theme deleted successfully.');
    }
}
