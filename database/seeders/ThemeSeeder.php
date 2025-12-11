<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        Theme::firstOrCreate(
            ['name' => 'Default Premium'],
            [
                'colors' => [
                    'primary' => '#0f766e', // Teal 700
                    'secondary' => '#ccfbf1', // Teal 100
                    'accent' => '#f59e0b', // Amber 500
                    'background' => '#ffffff',
                    'text' => '#0f172a', // Slate 900
                    'muted' => '#f1f5f9', // Slate 100
                ],
                'font_family' => 'Outfit',
                'status' => true,
                'start_date' => now(),
            ]
        );
    }
}
