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
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin & Fundraiser Tetap Sama
        $admin = User::firstOrCreate(['email' => 'super@admin'], [
            'name' => 'Super Admin Smartcare',
            'password' => Hash::make('super'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $fundraiser = User::firstOrCreate(['email' => 'budi@gmail.com'], [
            'name' => 'Budi Fundraiser',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'active',
        ]);

        // Kategori
        $catLingkungan = EntityCategory::firstOrCreate(['name' => 'Lingkungan']);
        $catSosial = EntityCategory::firstOrCreate(['name' => 'Sosial']);
        $catBencana = CampaignCategory::firstOrCreate(['name' => 'Bencana Alam']);
        $catKesehatan = CampaignCategory::firstOrCreate(['name' => 'Kesehatan']);

        // ==========================================
        // 2. SEEDER ENTITIES (8 Total: 4 Awal + 4 Baru)
        // ==========================================
        
        // 2 Pending
        foreach(['Yayasan Kasih', 'Komunitas Hijau'] as $name) {
            Entity::create([
                'user_id' => $fundraiser->id,
                'entity_category_id' => $catSosial->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'email' => Str::slug($name).'@mail.com',
                'address' => 'Alamat ' . $name,
                'status' => 'pending',
                'is_active' => true,
            ]);
        }

        // 2 Approved
        $entRelawan = Entity::create([
            'user_id' => $fundraiser->id,
            'entity_category_id' => $catLingkungan->id,
            'name' => 'Relawan Nusantara',
            'slug' => 'relawan-nusantara',
            'email' => 'relawan@nusantara.org',
            'address' => 'Jakarta Pusat',
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        Entity::create([
            'user_id' => $fundraiser->id,
            'entity_category_id' => $catSosial->id,
            'name' => 'Dana Abadi',
            'slug' => 'dana-abadi',
            'email' => 'contact@danaabadi.com',
            'address' => 'Bandung',
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // 2 Rejected
        foreach(['Grup Fiktif', 'Organisasi Gelap'] as $name) {
            Entity::create([
                'user_id' => $fundraiser->id,
                'entity_category_id' => $catSosial->id,
                'name' => $name,
                'slug' => Str::slug($name),
                'email' => Str::slug($name).'@mail.com',
                'address' => 'Tidak Diketahui',
                'status' => 'rejected',
                'rejection_reason' => 'Dokumen legalitas tidak valid atau buram.',
                'is_active' => false,
            ]);
        }

        // ==========================================
        // 3. SEEDER CAMPAIGNS & DONATIONS
        // ==========================================

        // --- 2 PENDING ---
        foreach(['Operasi Mata Pak Slamet', 'Renovasi Mushola Desa'] as $title) {
            Campaign::create([
                'user_id' => $fundraiser->id,
                'entity_id' => $entRelawan->id,
                'category_id' => $catKesehatan->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => 'Deskripsi untuk ' . $title,
                'goal_amount' => 5000000,
                'start_at' => now(),
                'end_at' => now()->addDays(30),
                'status' => 'pending',
            ]);
        }

        // --- 2 APPROVED (Masih Berjalan) ---
        $campApproved = Campaign::create([
            'user_id' => $fundraiser->id,
            'entity_id' => $entRelawan->id,
            'category_id' => $catBencana->id,
            'title' => 'Emergency Gempa Bumi',
            'slug' => 'emergency-gempa-bumi',
            'description' => 'Bantuan mendesak untuk tenda dan obat-obatan.',
            'goal_amount' => 20000000,
            'current_amount' => 5000000,
            'donors_count' => 1,
            'start_at' => now(),
            'end_at' => now()->addDays(15),
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        Donation::create([
            'campaign_id' => $campApproved->id,
            'name' => 'Donatur Baik',
            'amount' => 5000000,
            'status' => 'paid',
        ]);

        // --- 2 REJECTED ---
        foreach(['Liburan Mewah Admin', 'Project Tanpa Izin'] as $title) {
            Campaign::create([
                'user_id' => $fundraiser->id,
                'entity_id' => $entRelawan->id,
                'category_id' => $catBencana->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => 'Ditolak karena alasan tertentu.',
                'goal_amount' => 1000000,
                'start_at' => now(),
                'end_at' => now()->addDays(7),
                'status' => 'rejected',
                'rejection_reason' => 'Tujuan campaign tidak sesuai dengan kebijakan platform.',
            ]);
        }

        // --- 2 COMPLETED ---

        // 1. Completed karena Tanggal Selesai (Expired)
        $campExpired = Campaign::create([
            'user_id' => $fundraiser->id,
            'entity_id' => $entRelawan->id,
            'category_id' => $catSosial->id,
            'title' => 'Bantuan Sembako Ramadhan',
            'slug' => 'bantuan-sembako-ramadhan',
            'description' => 'Campaign ini sudah melewati batas waktu.',
            'goal_amount' => 10000000,
            'current_amount' => 2500000,
            'donors_count' => 1,
            'start_at' => now()->subMonths(2),
            'end_at' => now()->subDays(1), // Sudah lewat kemarin
            'status' => 'completed',
            'is_active' => true,
        ]);
        
        Donation::create([
            'campaign_id' => $campExpired->id,
            'name' => 'Dermawan',
            'amount' => 2500000,
            'status' => 'paid',
        ]);

        // 2. Completed karena Saldo Full (Target Tercapai)
        $campFull = Campaign::create([
            'user_id' => $fundraiser->id,
            'entity_id' => $entRelawan->id,
            'category_id' => $catKesehatan->id,
            'title' => 'Alat Bantu Dengar Siti',
            'slug' => 'alat-bantu-dengar-siti',
            'description' => 'Target tercapai 100%.',
            'goal_amount' => 15000000,
            'current_amount' => 15000000, // Full
            'donors_count' => 2,
            'start_at' => now()->subDays(10),
            'end_at' => now()->addDays(20),
            'status' => 'completed',
            'is_active' => true,
        ]);

        Donation::create([
            'campaign_id' => $campFull->id,
            'name' => 'Orang Kaya Baru',
            'amount' => 10000000,
            'status' => 'paid',
        ]);
        Donation::create([
            'campaign_id' => $campFull->id,
            'name' => 'Anonim',
            'amount' => 5000000,
            'status' => 'paid',
        ]);
    }
}