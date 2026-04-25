<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed a default admin user.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@repolabris.test'],
            [
                'name' => 'Admin LAB RIS',
                'password' => Hash::make('admin12345'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
