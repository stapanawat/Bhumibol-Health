<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SitemapCategory;
use Inertia\Inertia;

class SitemapController extends Controller
{
    public function index()
    {
        $categories = SitemapCategory::with([
            'sitemaps' => function ($query) {
                $query->where('status', true)->orderBy('order')->orderBy('title_th');
            }
        ])
            ->where('status', true)
            ->orderBy('order')
            ->orderBy('name_th')
            ->get();

        return Inertia::render('Sitemap', [
            'categories' => $categories
        ]);
    }
}
