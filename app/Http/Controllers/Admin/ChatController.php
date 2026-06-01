<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $adminId = Auth::id();

        // Get all users who have chatted with admin
        $conversations = Chat::where(function($q) use ($adminId) {
                $q->where('sender_id', $adminId)
                  ->orWhere('receiver_id', $adminId);
            })
            ->select('sender_id', 'receiver_id')
            ->get()
            ->map(function($chat) use ($adminId) {
                return $chat->sender_id == $adminId ? $chat->receiver_id : $chat->sender_id;
            })
            ->unique()
            ->values();

        $users = User::whereIn('id', $conversations)
            ->where('role', 'fundraiser')
            ->with(['sentChats' => function($q) use ($adminId) {
                $q->where('receiver_id', $adminId)
                  ->latest()
                  ->limit(1);
            }])
            ->get()
            ->map(function($user) use ($adminId) {
                $lastMessage = Chat::where(function($q) use ($user, $adminId) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $adminId)
                      ->orWhere('sender_id', $adminId)->where('receiver_id', $user->id);
                })->latest()->first();

                $unreadCount = Chat::where('sender_id', $user->id)
                    ->where('receiver_id', $adminId)
                    ->whereNull('read_at')
                    ->count();

                $user->last_message = $lastMessage;
                $user->unread_count = $unreadCount;
                return $user;
            });

        return view('admin.chats.index', compact('users'));
    }

    public function show($userId)
    {
        $adminId = Auth::id();
        $user = User::findOrFail($userId);

        // Get all messages between admin and this user
        $messages = Chat::where(function($q) use ($userId, $adminId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $userId)
                  ->orWhere('sender_id', $userId)->where('receiver_id', $adminId);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark all messages from this user as read
        Chat::where('sender_id', $userId)
            ->where('receiver_id', $adminId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('admin.chats.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Message sent successfully!');
    }
}
