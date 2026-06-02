<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdraw::with('campaign', 'campaign.user', 'approver')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('account_holder', 'like', "%$s%")
                  ->orWhere('bank_name', 'like', "%$s%")
                  ->orWhereHas('campaign', function($cq) use ($s) {
                      $cq->where('title', 'like', "%$s%")
                        ->orWhereHas('user', function($uq) use ($s) {
                            $uq->where('name', 'like', "%$s%");
                        });
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdraws = $query->paginate(10)->withQueryString();

        // Get counts for each status
        $pendingCount = Withdraw::where('status', 'pending')->count();
        $approvedCount = Withdraw::where('status', 'approved')->count();
        $rejectedCount = Withdraw::where('status', 'rejected')->count();

        if ($request->ajax()) {
            return view('admin.withdraws._table', compact('withdraws'))->render();
        }

        return view('admin.withdraws.index', compact('withdraws', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function approve(Request $request, $id)
    {
        $withdraw = Withdraw::findOrFail($id);

        $withdraw->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Withdrawal approved successfully']);
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $withdraw = Withdraw::findOrFail($id);

        $withdraw->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Withdrawal rejected successfully']);
    }

    public function show($id)
    {
        $withdraw = Withdraw::with('campaign', 'campaign.user', 'approver')->findOrFail($id);
        return response()->json($withdraw);
    }

    public function pending(Request $request)
    {
        $query = Withdraw::with('campaign', 'campaign.user', 'approver')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('account_holder', 'like', "%$s%")
                  ->orWhere('bank_name', 'like', "%$s%")
                  ->orWhereHas('campaign', function($cq) use ($s) {
                      $cq->where('title', 'like', "%$s%")
                        ->orWhereHas('user', function($uq) use ($s) {
                            $uq->where('name', 'like', "%$s%");
                        });
                  });
            });
        }

        $withdraws = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.withdraws._table', compact('withdraws'))->render();
        }

        return view('admin.withdraws.pending', compact('withdraws'));
    }

    public function approved(Request $request)
    {
        $query = Withdraw::with('campaign', 'campaign.user', 'approver')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('account_holder', 'like', "%$s%")
                  ->orWhere('bank_name', 'like', "%$s%")
                  ->orWhereHas('campaign', function($cq) use ($s) {
                      $cq->where('title', 'like', "%$s%")
                        ->orWhereHas('user', function($uq) use ($s) {
                            $uq->where('name', 'like', "%$s%");
                        });
                  });
            });
        }

        $withdraws = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.withdraws._table', compact('withdraws'))->render();
        }

        return view('admin.withdraws.approved', compact('withdraws'));
    }

    public function rejected(Request $request)
    {
        $query = Withdraw::with('campaign', 'campaign.user', 'approver')
            ->where('status', 'rejected')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('account_holder', 'like', "%$s%")
                  ->orWhere('bank_name', 'like', "%$s%")
                  ->orWhereHas('campaign', function($cq) use ($s) {
                      $cq->where('title', 'like', "%$s%")
                        ->orWhereHas('user', function($uq) use ($s) {
                            $uq->where('name', 'like', "%$s%");
                        });
                  });
            });
        }

        $withdraws = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.withdraws._table', compact('withdraws'))->render();
        }

        return view('admin.withdraws.rejected', compact('withdraws'));
    }
}
