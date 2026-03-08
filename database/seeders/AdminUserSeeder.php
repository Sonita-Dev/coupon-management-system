<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed the default admin account for production recovery.
     */
    public function run(): void
    {
        $email = (string) env('ADMIN_EMAIL', 'admin@gmail.com');
        $name = (string) env('ADMIN_NAME', 'Admin');
        $password = (string) env('ADMIN_PASSWORD', 'admin123');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );
    }
}
