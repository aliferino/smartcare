<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Individual', 'Foundation', 'Community', 'Student Organization'];

        foreach ($categories as $category) {
            DB::table('entity_categories')->insert([
                'name' => $category,
                'created_at' => now(),
            ]);
        }

        $fundraiser = DB::table('users')->where('role', 'fundraiser')->first();
        $catFoundation = DB::table('entity_categories')->where('name', 'Foundation')->first();

        if ($fundraiser && $catFoundation) {
            DB::table('entities')->insert([
                'user_id' => $fundraiser->id,
                'entity_category_id' => $catFoundation->id,
                'name' => 'Yayasan Berbagi Cahaya',
                'email' => 'contact@berbagicahaya.org',
                'address' => 'Jl. Kebaikan No. 404, Jakarta',
                'status' => 'approved',
                'created_at' => now(),
            ]);
        }
    }
}