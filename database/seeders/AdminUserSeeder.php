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
        User::create([
            'name' => 'Admin UMKM',
            'email' => 'admin@umkm.com',
            'phone' => '628123456789',
            'role' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create staff user
        User::create([
            'name' => 'Staff UMKM',
            'email' => 'staff@umkm.com',
            'phone' => '628987654321',
            'role' => 'staff',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
