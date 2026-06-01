<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    public function index(Request $request)
    {
        $query = Broadcast::with('user')->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $broadcasts = $query->paginate(15);

        return view('admin.broadcasts.index', compact('broadcasts'));
    }

    public function create()
    {
        return view('admin.broadcasts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $broadcast = Broadcast::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'message' => $request->message,
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.broadcasts.index')
            ->with('success', 'Broadcast sent successfully to all fundraisers!');
    }
}
