<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'email' => 'admin@charity.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
        ]);

        // Ambil Citizen dari CitizenSeeder
        $citizen = DB::table('citizens')->first();

        // Buat Fundraiser
        $fundraiserId = DB::table('users')->insertGetId([
            'name' => 'Budi Santoso',
            'email' => 'fundraiser@charity.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'citizen_id' => $citizen->id,
            'created_at' => now(),
        ]);

    }
}