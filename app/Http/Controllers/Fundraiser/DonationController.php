<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('campaign')
            ->whereHas('campaign', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('phone_number', 'like', "%$s%")
                  ->orWhereHas('campaign', function($cq) use ($s) {
                      $cq->where('title', 'like', "%$s%");
                  });
            });
        }

        $donations = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('fundraiser.donations._table', compact('donations'))->render();
        }

        return view('fundraiser.donations.index', compact('donations'));
    }
}
