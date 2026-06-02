<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdraw::with('campaign')
            ->whereHas('campaign', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('account_holder', 'like', "%$s%")
                  ->orWhere('bank_name', 'like', "%$s%")
                  ->orWhereHas('campaign', function($cq) use ($s) {
                      $cq->where('title', 'like', "%$s%");
                  });
            });
        }

        $withdraws = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('fundraiser.withdraws._table', compact('withdraws'))->render();
        }

        return view('fundraiser.withdraws.index', compact('withdraws'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'amount' => 'required|numeric|min:100000',
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:20',
            'account_holder' => 'required|string|max:100',
        ]);

        $campaign = Campaign::findOrFail($validated['campaign_id']);

        if ($campaign->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Calculate available amount (current_amount - pending/approved withdrawals)
        $totalWithdrawn = Withdraw::where('campaign_id', $campaign->id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        $availableAmount = $campaign->current_amount - $totalWithdrawn;

        // Validate withdrawal amount doesn't exceed available funds
        if ($validated['amount'] > $availableAmount) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'amount' => ['Withdrawal amount exceeds available funds. Available: Rp ' . number_format($availableAmount, 0, ',', '.')]
                ]
            ], 422);
        }

        Withdraw::create([
            'campaign_id' => $validated['campaign_id'],
            'amount' => $validated['amount'],
            'bank_name' => $validated['bank_name'],
            'account_number' => $validated['account_number'],
            'account_holder' => $validated['account_holder'],
            'status' => 'pending',
        ]);

        return response()->json(['success' => true, 'message' => 'Withdrawal request submitted successfully']);
    }

    public function show($id)
    {
        $withdraw = Withdraw::with('campaign')->findOrFail($id);

        if ($withdraw->campaign->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json($withdraw);
    }

    public function getCampaigns()
    {
        $campaigns = Campaign::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('is_active', true)
            ->select('id', 'title', 'current_amount')
            ->get();

        // Calculate available amount for each campaign
        $campaigns->each(function($campaign) {
            $totalWithdrawn = Withdraw::where('campaign_id', $campaign->id)
                ->whereIn('status', ['pending', 'approved'])
                ->sum('amount');

            $campaign->available_amount = $campaign->current_amount - $totalWithdrawn;
        });

        return response()->json(['campaigns' => $campaigns]);
    }
}
