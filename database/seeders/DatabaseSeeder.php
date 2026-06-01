<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Entity;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Citizen;
use App\Models\EntityCategory;
use App\Models\CampaignCategory;
use App\Models\Broadcast;
use App\Models\Chat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. ADMIN USER
        // ==========================================
        $admin = User::create([
            'name' => 'Super Admin SmartCare',
            'email' => 'super@admin',
            'password' => Hash::make('super'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // ==========================================
        // 2. CATEGORIES
        // ==========================================
        $entityCategories = [];
        $entityCategoryNames = [
            'Yayasan Pendidikan', 'Yayasan Sosial', 'Organisasi Lingkungan', 'Lembaga Kesehatan',
            'Komunitas Pendidikan', 'Relawan Kemanusiaan'
        ];
        foreach ($entityCategoryNames as $name) {
            $entityCategories[] = EntityCategory::create(['name' => $name]);
        }

        $campaignCategories = [];
        $campaignCategoryNames = [
            'Bencana Alam', 'Kesehatan', 'Pendidikan', 'Lingkungan', 'Sosial Kemanusiaan'
        ];
        foreach ($campaignCategoryNames as $name) {
            $campaignCategories[] = CampaignCategory::create(['name' => $name]);
        }

        // ==========================================
        // 3. BUDI - ACTIVE FUNDRAISER
        // ==========================================
        $budi = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'active',
        ]);

        Citizen::create([
            'user_id' => $budi->id,
            'full_name' => 'Budi Santoso',
            'id_number' => '3173010101850001',
            'gender' => 'male',
            'phone_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 45, Jakarta Pusat, DKI Jakarta 10110',
            'id_card_path' => 'kyc_docs/ktp_budi.jpg',
            'selfie_path' => 'kyc_selfies/selfie_budi.jpg',
            'profile_picture' => 'profiles/budi_avatar.jpg',
            'status' => 'approved',
            'verified_at' => now()->subDays(30),
            'verified_by' => $admin->id,
        ]);

        // Create entities for Budi
        $budiEntity = Entity::create([
            'name' => 'Yayasan Cahaya Harapan',
            'slug' => Str::slug('Yayasan Cahaya Harapan') . '-' . Str::random(6),
            'email' => 'cahayaharapan@entity.org',
            'address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            'entity_category_id' => $entityCategories[0]->id,
            'user_id' => $budi->id,
            'logo_path' => 'entities/logos/cahaya_harapan.jpg',
            'legal_document_path' => 'entities/documents/cahaya_harapan.pdf',
            'status' => 'approved',
            'approved_at' => now()->subDays(20),
            'approved_by' => $admin->id,
        ]);

        // Create campaigns for Budi
        $campaign1 = Campaign::create([
            'user_id' => $budi->id,
            'title' => 'Bantu Anak Yatim Mendapatkan Pendidikan Layak',
            'slug' => Str::slug('Bantu Anak Yatim Mendapatkan Pendidikan Layak') . '-' . Str::random(6),
            'description' => 'Kami membutuhkan bantuan Anda untuk memberikan pendidikan layak bagi anak-anak yatim. Program ini sangat penting untuk masa depan mereka.',
            'entity_id' => $budiEntity->id,
            'category_id' => $campaignCategories[2]->id,
            'goal_amount' => 50000000,
            'current_amount' => 15000000,
            'start_at' => now()->subDays(10),
            'end_at' => now()->addDays(60),
            'image_path' => 'campaigns/images/campaign1.jpg',
            'is_urgent' => true,
            'status' => 'approved',
            'approved_at' => now()->subDays(8),
            'approved_by' => $admin->id,
        ]);

        Campaign::create([
            'user_id' => $budi->id,
            'title' => 'Bantuan Korban Banjir Jakarta',
            'slug' => Str::slug('Bantuan Korban Banjir Jakarta') . '-' . Str::random(6),
            'description' => 'Bantuan untuk korban banjir yang kehilangan tempat tinggal dan harta benda.',
            'entity_id' => $budiEntity->id,
            'category_id' => $campaignCategories[0]->id,
            'goal_amount' => 30000000,
            'current_amount' => 5000000,
            'start_at' => now()->subDays(5),
            'end_at' => now()->addDays(30),
            'image_path' => 'campaigns/images/campaign2.jpg',
            'is_urgent' => false,
            'status' => 'approved',
            'approved_at' => now()->subDays(3),
            'approved_by' => $admin->id,
        ]);

        // Create donations
        Donation::create([
            'campaign_id' => $campaign1->id,
            'name' => 'Ahmad Hidayat',
            'email' => 'ahmad@gmail.com',
            'phone_number' => '081234567891',
            'amount' => 5000000,
            'payment_method' => 'bank_transfer',
            'status' => 'paid',
            'is_anonymous' => false,
            'message' => 'Semoga bermanfaat untuk anak-anak',
        ]);

        Donation::create([
            'campaign_id' => $campaign1->id,
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@gmail.com',
            'phone_number' => '081234567892',
            'amount' => 10000000,
            'payment_method' => 'e-wallet',
            'status' => 'paid',
            'is_anonymous' => false,
            'message' => 'Barakallah, semoga berkah',
        ]);

        // ==========================================
        // 4. JOKO - INACTIVE FUNDRAISER
        // ==========================================
        User::create([
            'name' => 'Joko Widodo',
            'email' => 'joko@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'inactive',
        ]);

        // ==========================================
        // 5. RINA - BANNED FUNDRAISER
        // ==========================================
        User::create([
            'name' => 'Rina Kusuma',
            'email' => 'rina@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'fundraiser',
            'status' => 'banned',
        ]);

    }
}
