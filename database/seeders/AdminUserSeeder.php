<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@umkm.com'],
            [
                'name' => 'Admin UMKM',
                'phone' => '628123456789',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create staff user
        User::updateOrCreate(
            ['email' => 'staff@umkm.com'],
            [
                'name' => 'Staff UMKM',
                'phone' => '628987654321',
                'role' => 'staff',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
