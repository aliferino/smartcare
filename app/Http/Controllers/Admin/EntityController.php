<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function index()
    {
        // Menggunakan 'status' sesuai revisi terbarumu
        $pendingEntities = Entity::with(['user', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.entity-approval', compact('pendingEntities'));
    }

    public function list()
    {
        // Mengambil yang sudah diputuskan (Approved/Rejected)
        $verifiedEntities = Entity::with(['user', 'category', 'admin'])
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        return view('admin.entity-list', compact('verifiedEntities'));
    }

    public function detail($id)
    {
        // Method detail untuk melihat semua data entitas
        $entity = Entity::with(['user', 'category', 'admin'])->findOrFail($id);

        return view('admin.entity-detail', compact('entity'));
    }

    public function approve($id)
    {
        $entity = Entity::where('status', 'pending')->findOrFail($id);
        
        $entity->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id() 
        ]);

        return redirect()->route('admin.entities.list')->with('success', "Entitas {$entity->name} disetujui.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5'
        ]);

        $entity = Entity::where('status', 'pending')->findOrFail($id);
        
        $entity->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason 
        ]);

        return redirect()->route('admin.entities.list')->with('error', "Entitas {$entity->name} ditolak.");
    }
}