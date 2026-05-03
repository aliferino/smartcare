<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitizenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('citizens')->insert([
            'full_name' => 'Budi Campaigner',
            'id_number' => '3201010101010001',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone_number' => '081234567890',
            'address' => 'Jl. Kemanusiaan No. 123',
            'id_card_path' => 'kyc_docs/ktp_budi.jpg',
            'selfie_path' => 'kyc_selfies/selfie_budi.jpg',
            'profile_picture' => 'profiles/budi_avatar.jpg',
            'status' => 'pending', 
            'created_at' => now(),
        ]);
    }
}