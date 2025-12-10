<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'media_path',
        'start_date',
        'end_date',
        'link',
        'display_duration',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => 'boolean',
    ];
}
