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
            'name' => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'active',
        ]);

        // Add approved citizen for Budi
        Citizen::firstOrCreate(['user_id' => $fundraiser->id], [
            'full_name' => 'Budi Santoso',
            'id_number' => '3173010101850001',
            'gender' => 'male',
            'phone_number' => '081234567891',
            'address' => 'Jl. Merdeka No. 45, Jakarta Pusat',
            'id_card_path' => 'kyc_docs/ktp_budi.jpg',
            'selfie_path' => 'kyc_selfies/selfie_budi.jpg',
            'profile_picture' => 'profiles/budi_avatar.jpg',
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => $admin->id,
        ]);

        // Citizen Scenarios
        // Scenario 1: Active user with approved citizen
        $activeUser = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'active',
        ]);

        Citizen::create([
            'user_id' => $activeUser->id,
            'full_name' => 'Siti Rahayu',
            'id_number' => '3201010101010001',
            'gender' => 'female',
            'phone_number' => '081234567890',
            'address' => 'Jl. Kemanusiaan No. 123, Jakarta Selatan',
            'id_card_path' => 'kyc_docs/ktp_siti.jpg',
            'selfie_path' => 'kyc_selfies/selfie_siti.jpg',
            'profile_picture' => 'profiles/siti_avatar.jpg',
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => $admin->id,
        ]);

        // Scenario 2: Inactive user without citizen
        User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'inactive',
        ]);

        // Scenario 3: Inactive user with pending citizen
        $inactiveUser = User::create([
            'name' => 'Rina Kusuma',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'inactive',
        ]);

        Citizen::create([
            'user_id' => $inactiveUser->id,
            'full_name' => 'Rina Kusuma',
            'id_number' => '3201010202020002',
            'gender' => 'female',
            'phone_number' => '081298765432',
            'address' => 'Jl. Perjuangan No. 456, Bandung',
            'id_card_path' => 'kyc_docs/ktp_rina.jpg',
            'selfie_path' => 'kyc_selfies/selfie_rina.jpg',
            'profile_picture' => 'profiles/rina_avatar.jpg',
            'status' => 'pending',
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

        // ==========================================
        // 4. ENTITIES & CAMPAIGNS FOR SITI
        // ==========================================

        // Siti's approved entity
        $sitiEntity = Entity::create([
            'user_id' => $activeUser->id,
            'entity_category_id' => $catSosial->id,
            'name' => 'Yayasan Peduli Anak',
            'slug' => 'yayasan-peduli-anak',
            'email' => 'info@pedulianak.org',
            'address' => 'Jl. Pendidikan No. 88, Jakarta Selatan',
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        // Siti's approved campaign with donations
        $sitiCampaign = Campaign::create([
            'user_id' => $activeUser->id,
            'entity_id' => $sitiEntity->id,
            'category_id' => $catKesehatan->id,
            'title' => 'Bantuan Operasi Jantung Anak',
            'slug' => 'bantuan-operasi-jantung-anak',
            'description' => 'Membantu biaya operasi jantung untuk anak-anak kurang mampu.',
            'goal_amount' => 30000000,
            'current_amount' => 12000000,
            'donors_count' => 3,
            'start_at' => now()->subDays(5),
            'end_at' => now()->addDays(25),
            'status' => 'approved',
            'is_active' => true,
            'approved_at' => now(),
        ]);

        Donation::create([
            'campaign_id' => $sitiCampaign->id,
            'name' => 'Keluarga Wijaya',
            'amount' => 5000000,
            'status' => 'paid',
        ]);

        Donation::create([
            'campaign_id' => $sitiCampaign->id,
            'name' => 'PT Sejahtera',
            'amount' => 5000000,
            'status' => 'paid',
        ]);

        Donation::create([
            'campaign_id' => $sitiCampaign->id,
            'name' => 'Hamba Allah',
            'amount' => 2000000,
            'status' => 'paid',
        ]);

        // ==========================================
        // 5. SUSPENDED FUNDRAISER WITH APPROVED CITIZEN
        // ==========================================

        $suspendedUser = User::create([
            'name' => 'Dedi Kurniawan',
            'email' => 'dedi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'suspended',
        ]);

        Citizen::create([
            'user_id' => $suspendedUser->id,
            'full_name' => 'Dedi Kurniawan',
            'id_number' => '3275010303880003',
            'gender' => 'male',
            'phone_number' => '081345678901',
            'address' => 'Jl. Veteran No. 67, Bekasi',
            'id_card_path' => 'kyc_docs/ktp_dedi.jpg',
            'selfie_path' => 'kyc_selfies/selfie_dedi.jpg',
            'profile_picture' => 'profiles/dedi_avatar.jpg',
            'status' => 'approved',
            'verified_at' => now()->subDays(10),
            'verified_by' => $admin->id,
        ]);

        // ==========================================
        // 6. BANNED FUNDRAISER WITH SUSPICIOUS ACTIVITY
        // ==========================================

        $bannedUser = User::create([
            'name' => 'Agus Setiawan',
            'email' => 'agus@scam.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'banned',
        ]);

        Citizen::create([
            'user_id' => $bannedUser->id,
            'full_name' => 'Agus Setiawan',
            'id_number' => '3374010404900004',
            'gender' => 'male',
            'phone_number' => '081456789012',
            'address' => 'Jl. Gelap No. 13, Semarang',
            'id_card_path' => 'kyc_docs/ktp_agus.jpg',
            'selfie_path' => 'kyc_selfies/selfie_agus.jpg',
            'profile_picture' => 'profiles/agus_avatar.jpg',
            'status' => 'approved',
            'verified_at' => now()->subDays(20),
            'verified_by' => $admin->id,
        ]);

        // Suspicious entity
        $suspiciousEntity = Entity::create([
            'user_id' => $bannedUser->id,
            'entity_category_id' => $catSosial->id,
            'name' => 'Yayasan Abal-Abal',
            'slug' => 'yayasan-abal-abal',
            'email' => 'fake@scam.com',
            'address' => 'Alamat Tidak Jelas',
            'status' => 'approved',
            'is_active' => false,
            'approved_at' => now()->subDays(15),
        ]);

        // Suspicious campaign
        $suspiciousCampaign = Campaign::create([
            'user_id' => $bannedUser->id,
            'entity_id' => $suspiciousEntity->id,
            'category_id' => $catBencana->id,
            'title' => 'Bantuan Darurat Palsu',
            'slug' => 'bantuan-darurat-palsu',
            'description' => 'Campaign mencurigakan dengan tujuan tidak jelas.',
            'goal_amount' => 50000000,
            'current_amount' => 8000000,
            'donors_count' => 2,
            'start_at' => now()->subDays(7),
            'end_at' => now()->addDays(23),
            'status' => 'approved',
            'is_active' => false,
            'approved_at' => now()->subDays(7),
        ]);

        // Suspicious donations
        Donation::create([
            'campaign_id' => $suspiciousCampaign->id,
            'name' => 'Donatur Mencurigakan',
            'amount' => 5000000,
            'status' => 'paid',
        ]);

        Donation::create([
            'campaign_id' => $suspiciousCampaign->id,
            'name' => 'Akun Palsu',
            'amount' => 3000000,
            'status' => 'paid',
        ]);
    }
}