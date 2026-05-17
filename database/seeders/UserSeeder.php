<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Portal Admin', 'email' => 'admin@portal.com', 'role' => 'admin'],
            ['name' => 'Staff Journalist', 'email' => 'journalist@portal.com', 'role' => 'journalist'],
            ['name' => 'Guest Reader', 'email' => 'guest@portal.com', 'role' => 'guest'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    ...$user,
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
