<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $fundraiserId = Auth::id();

        // Get all admin users
        $admins = User::where('role', 'admin')->get();

        // Get all messages between fundraiser and any admin
        $messages = Chat::where(function($q) use ($fundraiserId, $admins) {
                $adminIds = $admins->pluck('id');
                $q->where(function($q) use ($fundraiserId, $adminIds) {
                    $q->where('sender_id', $fundraiserId)->whereIn('receiver_id', $adminIds);
                })->orWhere(function($q) use ($fundraiserId, $adminIds) {
                    $q->whereIn('sender_id', $adminIds)->where('receiver_id', $fundraiserId);
                });
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark all messages from admin as read
        Chat::whereIn('sender_id', $admins->pluck('id'))
            ->where('receiver_id', $fundraiserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('fundraiser.chats.index', compact('messages', 'admins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Send message to first admin (or you can add logic to select specific admin)
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            return back()->with('error', 'No admin available to chat with.');
        }

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully!');
    }
}
