<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'colors',
        'font_family',
        'background_image',
        'start_date',
        'end_date',
        'status',
        'css_overrides',
    ];

    protected $casts = [
        'colors' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
    ];
}
