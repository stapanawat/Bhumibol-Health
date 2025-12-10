<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_th',
        'name_en',
        'specialty_th',
        'specialty_en',
        'image',
        'education_th',
        'education_en',
        'department',
        'order',
    ];

    //
}
