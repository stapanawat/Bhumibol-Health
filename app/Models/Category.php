<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_th',
        'name_en',
        'slug',
        'type',
        'is_active',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
