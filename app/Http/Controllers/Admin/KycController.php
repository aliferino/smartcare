<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function index()
    {
        $pendingKyc = Citizen::where('status', 'pending')->latest()->get();
        return view('admin.kyc-approval', compact('pendingKyc'));
    }


    public function list()
    {
        $verifiedCitizens = Citizen::whereIn('status', ['approved', 'rejected'])->latest()->get();
        return view('admin.kyc-list', compact('verifiedCitizens'));
    }

    public function detail($id)
    {
        $citizen = Citizen::findOrFail($id);
        return view('admin.kyc-detail', compact('citizen'));
    }

    public function approve($id)
    {
        $kyc = Citizen::findOrFail($id);
        $kyc->update([
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id()
        ]);

        return redirect()->route('admin.users.kyc.list')->with('success', 'User berhasil diverifikasi.');
    }
    public function reject(Request $request, $id)
    {
        $kyc = Citizen::where('status', 'pending')->findOrFail($id);
        
        $kyc->update([
            'status' => 'rejected',
            'reject_reason' => $request->reason
        ]);

        return redirect()->route('admin.users.kyc.verif')->with('error', 'Verifikasi ditolak.');
    }
}