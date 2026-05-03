<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\CampaignCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    public function index()
    {
        // Hanya ambil campaign milik user yang login, load kategori untuk efisiensi
        $campaigns = Campaign::where('user_id', Auth::id())
            ->with(['category', 'images'])
            ->latest()
            ->get();
            
        return view('fundraiser.campaign-list', compact('campaigns'));
    }

    public function create()
    {
        // Pastikan fundraiser punya entitas yang sudah disetujui admin
        $entities = Entity::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->get();

        if ($entities->isEmpty()) {
            return redirect()->route('fundraiser.entities.index')
                ->with('error', 'Anda harus memiliki lembaga yang disetujui sebelum membuat campaign.');
        }

        $categories = CampaignCategory::all();
        return view('fundraiser.campaign-add', compact('entities', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'entity_id'   => 'required|exists:entities,id',
            'category_id' => 'required|exists:campaign_categories,id',
            'title'       => 'required|max:255',
            'goal_amount' => 'required|numeric|min:1000',
            'end_at'      => 'required|date|after:today',
            'description' => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Buat Campaign
        $campaign = Campaign::create([
            'user_id'     => Auth::id(),
            'entity_id'   => $request->entity_id,
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
            'is_urgent'   => $request->has('is_urgent'),
            'goal_amount' => $request->goal_amount,
            'start_at'    => now(),
            'end_at'      => $request->end_at,
            'status'      => 'pending', 
        ]);

        // 2. Simpan Gambar ke tabel campaign_images
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaigns', 'public');
            $campaign->images()->create([
                'image_path' => $path,
                'is_primary' => true
            ]);
        }

        return redirect()->route('fundraiser.campaigns.index')->with('success', 'Campaign diajukan ke admin!');
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->user_id !== Auth::id()) abort(403);

        $totalDonations = $campaign->donations()->where('status', 'approved')->sum('amount');
        $totalWithdrawals = $campaign->withdraws()->where('status', 'approved')->sum('amount');
        $balance = $totalDonations - $totalWithdrawals;

        if ($balance > 0) {
            return back()->with('error', 'Campaign tidak bisa dihapus karena masih memiliki saldo Rp ' . number_format($balance, 0, ',', '.') . '. Silakan lakukan penarikan terlebih dahulu.');
        }

        if ($campaign->donations()->exists()) {
            return back()->with('error', 'Campaign yang sudah pernah menerima donasi tidak bisa dihapus untuk keperluan audit.');
        }

        foreach ($campaign->images as $image) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $campaign->delete();

        return redirect()->route('fundraiser.campaigns.index')->with('success', 'Campaign dihapus.');
    }
}