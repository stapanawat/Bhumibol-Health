<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitemapCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_th',
        'name_en',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function sitemaps()
    {
        return $this->hasMany(Sitemap::class)->orderBy('order')->orderBy('title_th');
    }
}
