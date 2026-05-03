<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Entity;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Citizen;
use App\Models\EntityCategory;
use App\Models\CampaignCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seeder Super Admin
        $admin = User::create([
            'name' => 'Super Admin Smartcare',
            'email' => 'super@admin',
            'password' => Hash::make('super'),
            'role' => 'admin',
            'profile_picture' => null, // Biarkan null untuk fallback inisial huruf
            'status' => 'active',
        ]);

        // 2. Seeder Fundraiser
        $fundraiser = User::create([
            'name' => 'Budi Fundraiser',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'profile_picture' => null,
            'status' => 'active',
        ]);

        // 3. Seeder Data Citizen (KYC) untuk Budi
        // Disesuaikan dengan skema tabel citizens kamu
        Citizen::create([
            'user_id' => $fundraiser->id,
            'full_name' => 'Budi Setiawan',
            'id_number' => '3201234567890001',
            'birth_date' => '1995-05-20',
            'gender' => 'male',
            'phone_number' => '08123456789',
            'address' => 'Jl. Merdeka No. 123, Jakarta Tengah',
            'id_card_path' => 'kyc/id_cards/budi_ktp.jpg',
            'selfie_path' => 'kyc/selfies/budi_selfie.jpg',
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => $admin->id,
        ]);

        // 4. Seeder Kategori
        $catLingkungan = EntityCategory::create(['name' => 'Yayasan Lingkungan']);
        EntityCategory::create(['name' => 'Lembaga Pendidikan']);
        $catBencana = CampaignCategory::create(['name' => 'Bencana Alam']);

        // 5. Seeder Entity
        $entity = Entity::create([
            'user_id' => $fundraiser->id,
            'entity_category_id' => $catLingkungan->id,
            'name' => 'Green Earth Foundation',
            'slug' => 'green-earth-foundation',
            'email' => 'contact@greenearth.org',
            'address' => 'Jakarta',
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // 6. Seeder Campaign
        $campaign = Campaign::create([
            'user_id' => $fundraiser->id,
            'entity_id' => $entity->id,
            'category_id' => $catBencana->id,
            'title' => 'Bantu Korban Banjir',
            'slug' => 'bantu-korban-banjir',
            'description' => 'Bantuan untuk sembako dan pakaian layak pakai.',
            'goal_amount' => 10000000,
            'current_amount' => 1500000,
            'donors_count' => 2,
            'start_at' => now(),
            'end_at' => now()->addMonths(1),
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // 7. Seeder Donasi
        Donation::create([
            'campaign_id' => $campaign->id,
            'name' => 'Hamba Allah',
            'email' => 'anonim@mail.com',
            'amount' => 1000000,
            'payment_method' => 'QRIS',
            'is_anonymous' => true,
            'status' => 'paid',
        ]);

        Donation::create([
            'campaign_id' => $campaign->id,
            'name' => 'Andi Pratama',
            'email' => 'andi@mail.com',
            'amount' => 500000,
            'payment_method' => 'Transfer Bank',
            'is_anonymous' => false,
            'status' => 'paid',
        ]);
    }
}