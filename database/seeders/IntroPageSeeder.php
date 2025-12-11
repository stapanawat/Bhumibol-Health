<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\IntroPage;

class IntroPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if intro pages already exist to avoid duplication
        if (IntroPage::count() > 0) {
            return;
        }

        // Create sample intro pages
        $intros = [
            [
                'title' => 'Welcome to Bhumibol Adulyadej Hospital',
                'type' => 'image',
                // Using a placeholder image that is likely to exist or a generic URL if allowed. 
                // Since I cannot upload files, I will use a placeholder URL or assume a seeder image exists.
                // For now, let's use a placeholder from an external source or just a dummy path.
                // NOTE: In a real scenario, this should be a local path in storage/app/public.
                // I will use a dummy path and user might not see the image if it doesn't exist, 
                // BUT the structure will be there.
                'media_path' => 'intro-pages/sample-1.jpg',
                'link' => '/services',
                'display_duration' => 5,
                'status' => true,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Advanced Medical Technology',
                'type' => 'image',
                'media_path' => 'intro-pages/sample-2.jpg',
                'link' => '/doctors',
                'display_duration' => 5,
                'status' => true,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('intro_pages')->insert($intros);
    }
}
