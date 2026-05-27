<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get statistics
        $stats = [
            'total_campaigns' => Campaign::where('status', 'approved')
                ->where('is_active', true)
                ->count(),
            'total_raised' => Campaign::where('status', 'approved')
                ->sum('current_amount'),
            'total_donors' => Campaign::where('status', 'approved')
                ->sum('donors_count'),
        ];

        // Get urgent campaigns
        $urgentCampaigns = Campaign::with(['primaryImage', 'campaignCategory'])
            ->where('status', 'approved')
            ->where('is_active', true)
            ->where('is_urgent', true)
            ->where('end_at', '>', now())
            ->latest('created_at')
            ->take(4)
            ->get()
            ->map(function($campaign) {
                $campaign->progress_percentage = $campaign->goal_amount > 0
                    ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2)
                    : 0;
                return $campaign;
            });

        // Get all active campaigns
        $campaigns = Campaign::with(['primaryImage', 'campaignCategory'])
            ->where('status', 'approved')
            ->where('is_active', true)
            ->where('end_at', '>', now())
            ->latest('created_at')
            ->take(8)
            ->get()
            ->map(function($campaign) {
                $campaign->progress_percentage = $campaign->goal_amount > 0
                    ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2)
                    : 0;
                return $campaign;
            });

        // Get categories for filter
        $categories = CampaignCategory::all();

        return view('web.home.index', compact('stats', 'urgentCampaigns', 'campaigns', 'categories'));
    }

    public function show($slug)
    {
        $campaign = Campaign::with(['primaryImage', 'images', 'category', 'entity', 'user'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->firstOrFail();

        $campaign->progress_percentage = $campaign->goal_amount > 0
            ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2)
            : 0;

        return view('web.campaign-detail', compact('campaign'));
    }
}
