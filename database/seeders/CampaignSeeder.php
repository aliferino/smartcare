<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CampaignSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Kategori Campaign (Tetap sama)
        $categories = ['Health', 'Education', 'Disaster', 'Social'];
        foreach ($categories as $cat) {
            DB::table('campaign_categories')->updateOrInsert(
                ['name' => $cat],
                ['created_at' => now()]
            );
        }

        // 2. Ambil Entity dan Kategori
        $entity = DB::table('entities')->where('status', 'approved')->first();
        $category = DB::table('campaign_categories')->where('name', 'Health')->first();

        if ($entity && $category) {
            // Masukkan data dengan user_id yang diambil dari entity
            $campaignId = DB::table('campaigns')->insertGetId([
                'user_id'     => $entity->user_id, // JANGAN DILUPAKAN LAGI!
                'entity_id'   => $entity->id,
                'category_id' => $category->id,
                'title'       => 'Bantuan Medis Darurat Korban Ledakan',
                'slug'        => Str::slug('Bantuan Medis Darurat Korban Ledakan') . '-' . Str::random(5),
                'description' => 'Dana medis untuk operasi tangan segera dan perawatan intensif.',
                'is_urgent'   => true,
                'goal_amount' => 35000000,
                'start_at'    => now(),
                'end_at'      => now()->addDays(30),
                'status'      => 'approved',
                'created_at'  => now(),
            ]);

            // Gambar Campaign (Tetap sama)
            DB::table('campaign_images')->insert([
                'campaign_id' => $campaignId,
                'image_path'  => 'campaigns/default.jpg',
                'is_primary'  => true,
                'created_at'  => now(),
            ]);
        } else {
            $this->command->error("Gagal seeding: Pastikan sudah ada Entity yang statusnya 'approved'!");
        }
    }
}