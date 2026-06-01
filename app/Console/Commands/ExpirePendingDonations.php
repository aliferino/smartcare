<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Models\Campaign;
use Illuminate\Console\Command;

class ExpirePendingDonations extends Command
{
    protected $signature = 'donations:expire-pending';
    protected $description = 'Expire pending donations older than 30 seconds';

    public function handle()
    {
        $thirtySecondsAgo = now()->subSeconds(30);

        $expiredDonations = Donation::where('status', 'pending')
            ->where('created_at', '<', $thirtySecondsAgo)
            ->get();

        foreach ($expiredDonations as $donation) {
            $campaign = Campaign::find($donation->campaign_id);

            if ($campaign) {
                $campaign->current_amount -= $donation->amount;
                $campaign->save();
            }

            $donation->update(['status' => 'expired']);
        }

        $this->info("Expired {$expiredDonations->count()} pending donations");
    }
}
