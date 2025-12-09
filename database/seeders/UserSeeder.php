<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin role exists, if not run RoleSeeder (safety check)
        if (Role::count() == 0) {
            $this->call(RoleSeeder::class);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@bhumibol.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        $this->command->info('Admin user created/updated: admin@bhumibol.com / password');
    }
}
