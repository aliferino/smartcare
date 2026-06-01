<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index(Request $request)
    {
        $query = Broadcast::whereNotNull('sent_at')
            ->orderBy('sent_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $broadcasts = $query->paginate(15);

        return view('fundraiser.inbox.index', compact('broadcasts'));
    }

    public function show($id)
    {
        $broadcast = Broadcast::findOrFail($id);

        return view('fundraiser.inbox.show', compact('broadcast'));
    }
}
