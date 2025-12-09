<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title_th',
        'title_en',
        'slug',
        'content_th',
        'content_en',
        'excerpt_th',
        'excerpt_en',
        'image',
        'status',
        'published_at',
        'views_count',
        'is_pinned',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_pinned' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
