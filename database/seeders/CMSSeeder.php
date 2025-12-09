<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CMSSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $cats = [
            [
                'name_th' => 'News & Announcements',
                'name_en' => 'News & Announcements',
                'type' => 'news',
                'slug' => 'news'
            ],
            [
                'name_th' => 'Medical Articles',
                'name_en' => 'Medical Articles',
                'type' => 'article',
                'slug' => 'articles'
            ],
            [
                'name_th' => 'Hospital Activities',
                'name_en' => 'Hospital Activities',
                'type' => 'activity',
                'slug' => 'activities'
            ],
            [
                'name_th' => 'Procurement',
                'name_en' => 'Procurement',
                'type' => 'procurement',
                'slug' => 'procurement'
            ]
        ];

        foreach ($cats as $c) {
            Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // 2. Create Dummy Posts
        $newsCat = Category::where('slug', 'news')->first();
        $admin = User::first(); // Assuming admin exists from previous steps

        if ($newsCat && $admin) {
            Post::firstOrCreate([
                'slug' => 'welcome-to-new-website'
            ], [
                'user_id' => $admin->id,
                'category_id' => $newsCat->id,
                'title_th' => 'ยินดีต้อนรับสู่เว็บไซต์ใหม่ โรงพยาบาลภูมิพลอดุลยเดช',
                'title_en' => 'Welcome to the new Bhumibol Adulyadej Hospital website',
                'content_th' => '<p>เราได้ปรับปรุงเว็บไซต์ใหม่เพื่อการเข้าถึงข้อมูลที่สะดวกและรวดเร็วยิ่งขึ้น...</p>',
                'content_en' => '<p>We have updated our website for better accessibility and speed...</p>',
                'excerpt_th' => 'เปิดตัวเว็บไซต์โฉมใหม่ ทันสมัย ใช้งานง่าย',
                'excerpt_en' => 'Launching our new modern and user-friendly website.',
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}
