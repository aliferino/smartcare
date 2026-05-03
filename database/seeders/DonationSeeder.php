<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\Campaign;

class DonationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil satu campaign sebagai contoh
        $campaign = Campaign::first();

        if ($campaign) {
            Donation::create([
                'campaign_id'  => $campaign->id,
                'name'         => 'Kind Donor',       // Ubah dari 'nama'
                'email'        => 'donor@gmail.com',
                'phone_number' => '0899999999',       // Ubah dari 'no_telp'
                'message'      => 'God bless this cause.', // Ubah dari 'pesan'
                'amount'       => 1000000,            // Ubah dari 'jumlah'
                'status'       => 'paid',
                'created_at'   => now(),
            ]);
        }
    }
}