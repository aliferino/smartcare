<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Entity;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Withdraw;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all campaigns for this fundraiser
        $campaigns = Campaign::where('user_id', $user->id)->get();

        // Calculate total funds raised from all campaigns
        $totalRaised = $campaigns->sum('current_amount');

        // Get entities statistics
        $totalEntities = Entity::where('user_id', $user->id)->count();
        $pendingEntitiesCount = Entity::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Get campaigns statistics
        $totalCampaigns = $campaigns->count();
        $pendingCampaignsCount = $campaigns->where('status', 'pending')->count();

        // Calculate available balance (for now, same as total raised)
        $balance = $totalRaised;

        // Calculate withdrawable amount (total raised - approved withdrawals)
        $approvedWithdrawals = Withdraw::whereHas('campaign', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('status', 'approved')
        ->sum('amount');

        $withdrawableAmount = $totalRaised - $approvedWithdrawals;

        // Get recent donations (last 10)
        $recentDonations = Donation::whereHas('campaign', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('campaign')
        ->where('status', 'paid')
        ->latest()
        ->take(10)
        ->get();

        // Get KYC status
        $citizen = $user->citizen;
        $kycStatus = $citizen ? $citizen->status : 'not_submitted';

        $stats = [
            'total_raised' => $totalRaised,
            'total_entities' => $totalEntities,
            'pending_entities_count' => $pendingEntitiesCount,
            'total_campaigns' => $totalCampaigns,
            'pending_campaigns_count' => $pendingCampaignsCount,
            'balance' => $balance,
            'withdrawable_amount' => $withdrawableAmount,
        ];

        return view('fundraiser.index', compact('stats', 'recentDonations', 'kycStatus', 'citizen'));
    }
}
