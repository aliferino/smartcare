<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignCategory;
use App\Models\Donation;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = Campaign::with(['campaignCategory'])
            ->where('status', 'approved')
            ->where('is_active', true)
            ->where('end_at', '>', now());

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by multiple categories
        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $query->whereIn('category_id', $request->categories);
        }

        // Filter by campaign types (urgent/normal)
        if ($request->has('types') && is_array($request->types) && count($request->types) > 0) {
            if (in_array('urgent', $request->types) && !in_array('normal', $request->types)) {
                $query->where('is_urgent', true);
            } elseif (in_array('normal', $request->types) && !in_array('urgent', $request->types)) {
                $query->where('is_urgent', false);
            }
            // If both are selected, show all (no filter needed)
        }

        // Sort options
        $sort = $request->get('sort', 'urgent');

        switch ($sort) {
            case 'urgent':
                // Urgent campaigns first (newest), then non-urgent (newest)
                $query->orderByRaw('is_urgent DESC, created_at DESC');
                break;
            case 'newest':
                $query->latest('created_at');
                break;
            case 'ending':
                $query->orderBy('end_at', 'asc');
                break;
            default:
                $query->orderByRaw('is_urgent DESC, created_at DESC');
        }

        $campaigns = $query->paginate(16)
            ->through(function($campaign) {
                $campaign->progress_percentage = $campaign->goal_amount > 0
                    ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2)
                    : 0;
                return $campaign;
            });

        // Get categories for filter
        $categories = CampaignCategory::all();

        return view('web.campaigns.index', compact('campaigns', 'categories'));
    }

    public function show($slug)
    {
        $campaign = Campaign::with(['campaignCategory', 'entity', 'user'])
            ->where('slug', $slug)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->firstOrFail();

        $campaign->progress_percentage = $campaign->goal_amount > 0
            ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2)
            : 0;

        return view('web.campaigns.show', compact('campaign'));
    }

    public function storeDonation(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'amount' => 'required|numeric|min:1000',
            'message' => 'nullable|string|max:500',
            'is_anonymous' => 'nullable|boolean',
            'payment_method' => 'required|string'
        ]);

        // If name is empty and not anonymous, set to "Someone"
        $name = $validated['name'];
        if (empty($name) && !($validated['is_anonymous'] ?? false)) {
            $name = 'Someone';
        }

        $donation = Donation::create([
            'campaign_id' => $validated['campaign_id'],
            'name' => ($validated['is_anonymous'] ?? false) ? null : $name,
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'amount' => $validated['amount'],
            'message' => $validated['message'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Donasi berhasil dibuat',
            'donation_id' => $donation->id
        ]);
    }

    public function updateDonationStatus(Donation $donation, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,failed,refunded,expired'
        ]);

        $oldStatus = $donation->status;
        $newStatus = $validated['status'];

        if ($oldStatus === 'pending' && $newStatus === 'paid') {
            $campaign = Campaign::find($donation->campaign_id);
            if ($campaign) {
                $campaign->current_amount += $donation->amount;
                $campaign->save();
            }
        } elseif ($oldStatus === 'pending' && $newStatus === 'expired') {
            $campaign = Campaign::find($donation->campaign_id);
            if ($campaign) {
                $campaign->current_amount -= $donation->amount;
                $campaign->save();
            }
        }

        $donation->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Status donasi berhasil diperbarui',
            'status' => $donation->status
        ]);
    }
}
