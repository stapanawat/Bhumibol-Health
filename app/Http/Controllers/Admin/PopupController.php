<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $popups = Popup::latest()->get();
        return Inertia::render('Admin/Popups/Index', [
            'popups' => $popups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Popups/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image_file' => 'required|file|image|max:10240', // 10MB
            'link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
            'frequency' => 'required|in:once_per_session,always,once_per_day',
        ]);

        $path = $request->file('image_file')->store('popups', 'public');

        Popup::create([
            'title' => $validated['title'],
            'image_path' => '/storage/' . $path,
            'link' => $validated['link'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'frequency' => $validated['frequency'],
        ]);

        return redirect()->route('admin.popups.index')->with('success', 'Popup created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Popup $popup)
    {
        return Inertia::render('Admin/Popups/Edit', [
            'popup' => $popup
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Popup $popup)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
            'frequency' => 'required|in:once_per_session,always,once_per_day',
        ];

        if ($request->hasFile('image_file')) {
            $rules['image_file'] = 'file|image|max:10240';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('image_file')) {
            if ($popup->image_path) {
                $oldPath = str_replace('/storage/', '', $popup->image_path);
                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image_file')->store('popups', 'public');
            $popup->image_path = '/storage/' . $path;
        }

        $popup->update([
            'title' => $validated['title'],
            'link' => $validated['link'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => $validated['status'],
            'frequency' => $validated['frequency'],
        ]);

        return redirect()->route('admin.popups.index')->with('success', 'Popup updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Popup $popup)
    {
        if ($popup->image_path) {
            $oldPath = str_replace('/storage/', '', $popup->image_path);
            Storage::disk('public')->delete($oldPath);
        }

        $popup->delete();

        return redirect()->back()->with('success', 'Popup deleted successfully.');
    }
}
