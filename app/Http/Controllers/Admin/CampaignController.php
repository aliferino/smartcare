<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace sesuai folder

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        // Gunakan paginate, jangan get() kalau tidak mau server meledak
        $pendingCampaigns = Campaign::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.campaign-approval', compact('pendingCampaigns'));
    }

    public function list()
    {
        // Mengambil campaign yang sudah disetujui (aktif)
        $activeCampaigns = Campaign::with('entity') // Gunakan relasi organization sesuai Model Anda
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('admin.campaign-list', compact('activeCampaigns'));
    }

    public function detail($id)
    {
        // Mengambil data lengkap termasuk relasi user, entity, dan category
        $campaign = Campaign::with(['user', 'entity', 'category'])->findOrFail($id);

        // Hitung persentase secara manual untuk jaga-jaga jika tidak ada di model
        $percentage = $campaign->goal_amount > 0 
            ? ($campaign->current_amount / $campaign->goal_amount) * 100 
            : 0;

        return view('admin.campaign-detail', compact('campaign', 'percentage'));
    }

    public function approve($id)
    {
        // Pastikan hanya yang berstatus pending yang bisa di-approve
        $campaign = Campaign::where('status', 'pending')->findOrFail($id);
        
        $campaign->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id()
        ]);

        return back()->with('success', 'Campaign approved!');
    }

    public function reject(Request $request, $id)
    {
        // Fitur wajib: Menolak campaign bermasalah
        $campaign = Campaign::where('status', 'pending')->findOrFail($id);
        
        $campaign->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason // Pastikan kolom ini ada di migrasi
        ]);

        return back()->with('error', 'Campaign rejected.');
    }
}