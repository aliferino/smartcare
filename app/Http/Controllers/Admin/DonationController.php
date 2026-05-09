<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::with('campaign')->orderBy('created_at', 'desc');

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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $donations = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('admin.donations._table', compact('donations'))->render();
        }

        return view('admin.donations.index', compact('donations'));
    }
}