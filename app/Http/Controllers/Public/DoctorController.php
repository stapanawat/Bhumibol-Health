<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Inertia\Inertia;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('order')
            ->orderBy('created_at')
            ->get();

        return Inertia::render('Doctors/Index', [
            'doctors' => $doctors
        ]);
    }
}
