<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats['total_entities'] = Entity::count();
        $stats['pending_entities'] = Entity::where('status', 'pending')->count();

        $stats['total_campaigns'] = Campaign::count();
        $stats['pending_campaigns'] = Campaign::where('status', 'pending')->count();

        $stats['total_donation_amount'] = Donation::where('status', 'paid')->sum('amount');
        $stats['total_donors'] = Donation::where('status', 'paid')->count();
        
        $chartData = Donation::where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recentDonations = Donation::with('campaign')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.index', compact('stats', 'recentDonations', 'chartData'));
    }
}