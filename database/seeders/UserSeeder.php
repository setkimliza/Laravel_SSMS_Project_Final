<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'phone' => '+1 (555) 234-5678',
                'address' => '742 Evergreen Terrace, Springfield',
                'password' => Hash::make('123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'sarah@example.com'],
            [
                'name' => 'Sarah Connor',
                'phone' => '+1 (555) 876-5432',
                'address' => '101 Cyberdyne Way, Los Angeles, CA',
                'password' => Hash::make('123'),
            ]
        );
    }
}
