<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntroPage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class IntroPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $introPages = IntroPage::latest()->get();
        return Inertia::render('Admin/IntroPages/Index', [
            'introPages' => $introPages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/IntroPages/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video',
            'media_file' => 'required|file|max:20480', // 20MB max
            'link' => 'nullable|url',
            'display_duration' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ]);

        $path = $request->file('media_file')->store('intro_pages', 'public');

        IntroPage::create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'media_path' => '/storage/' . $path,
            'link' => $validated['link'] ?? null,
            'display_duration' => $validated['display_duration'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.intro-pages.index')->with('success', 'Intro Page created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IntroPage $introPage)
    {
        return Inertia::render('Admin/IntroPages/Edit', [
            'introPage' => $introPage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IntroPage $introPage)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video',
            'link' => 'nullable|url',
            'display_duration' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ];

        // Media file is optional on update
        if ($request->hasFile('media_file')) {
            $rules['media_file'] = 'file|max:20480';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('media_file')) {
            // Delete old
            if ($introPage->media_path) {
                $oldPath = str_replace('/storage/', '', $introPage->media_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('media_file')->store('intro_pages', 'public');
            $introPage->media_path = '/storage/' . $path;
        }

        $introPage->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'link' => $validated['link'] ?? null,
            'display_duration' => $validated['display_duration'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.intro-pages.index')->with('success', 'Intro Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntroPage $introPage)
    {
        if ($introPage->media_path) {
            $oldPath = str_replace('/storage/', '', $introPage->media_path);
            Storage::disk('public')->delete($oldPath);
        }

        $introPage->delete();

        return redirect()->back()->with('success', 'Intro Page deleted successfully.');
    }
}
