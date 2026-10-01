<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Staff::firstOrCreate(
            ['UserName' => 'admin'],
            [
                'Password' => Hash::make('123'),
                'Role' => 'Admin',
            ]
        );

        Staff::firstOrCreate(
            ['UserName' => 'stock'],
            [
                'Password' => Hash::make('123'),
                'Role' => 'Stock',
            ]
        );
    }
}
