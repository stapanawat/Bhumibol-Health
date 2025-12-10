<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('order')->latest()->paginate(10);
        return Inertia::render('Admin/Doctors/Index', [
            'doctors' => $doctors
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Doctors/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'specialty_th' => 'required|string|max:255',
            'specialty_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'education_th' => 'nullable|string',
            'education_en' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('doctors', 'public');
            $validated['image'] = $path;
        }

        Doctor::create($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return Inertia::render('Admin/Doctors/Edit', [
            'doctor' => $doctor
        ]);
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name_th' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'specialty_th' => 'required|string|max:255',
            'specialty_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'education_th' => 'nullable|string',
            'education_en' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }
            $path = $request->file('image')->store('doctors', 'public');
            $validated['image'] = $path;
        }

        $doctor->update($validated);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->image) {
            Storage::disk('public')->delete($doctor->image);
        }
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
