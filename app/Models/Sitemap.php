<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    use HasFactory;

    protected $fillable = [
        'sitemap_category_id',
        'title_th',
        'title_en',
        'link',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(SitemapCategory::class, 'sitemap_category_id');
    }
}
