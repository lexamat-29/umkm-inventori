<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration:
     * 1. Sets default role 'staff' for any users without a role
     * 2. Creates an admin user if none exists (for initial setup)
     *
     * @return void
     */
    public function up()
    {
        // Set default role 'staff' for users without a role
        DB::table('users')
            ->whereNull('role')
            ->orWhere('role', '')
            ->update(['role' => 'staff']);

        // Create admin user if no admin exists
        $adminExists = DB::table('users')->where('role', 'admin')->exists();
        
        if (!$adminExists) {
            // Check if there's at least one user - make the first user admin
            $firstUser = DB::table('users')->orderBy('id')->first();
            
            if ($firstUser) {
                // Promote first user to admin
                DB::table('users')
                    ->where('id', $firstUser->id)
                    ->update(['role' => 'admin']);
                    
                echo "User '{$firstUser->email}' has been promoted to admin.\n";
            } else {
                // Create default admin user
                DB::table('users')->insert([
                    'name' => 'Administrator',
                    'email' => 'admin@umkm.local',
                    'password' => Hash::make('admin123'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                echo "Default admin user created: admin@umkm.local (password: admin123)\n";
                echo "⚠️  IMPORTANT: Change this password immediately after first login!\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // We don't remove roles on rollback as it could break the application
        // If needed, manually reset roles
    }
};
