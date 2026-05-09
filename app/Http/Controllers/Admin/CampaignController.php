<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignCategory;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $counts = [
            'pending'   => Campaign::where('status', 'pending')->count(),
            'approved'  => Campaign::where('status', 'approved')->count(),
            'rejected'  => Campaign::where('status', 'rejected')->count(),
            'completed' => Campaign::where('status', 'completed')->count(),
        ];

        $campaigns = Campaign::with(['entity', 'campaignCategory', 'primaryImage'])
            ->latest('updated_at')
            ->paginate(5);

        if ($request->ajax()) {
            return view('admin.campaigns._table', ['campaigns' => $campaigns, 'context' => 'index'])->render();
        }

        return view('admin.campaigns.index', compact('counts', 'campaigns'));
    }

    public function pending(Request $request)   { return $this->listByStatus($request, 'pending'); }
    public function approved(Request $request)  { return $this->listByStatus($request, 'approved'); }
    public function rejected(Request $request)  { return $this->listByStatus($request, 'rejected'); }
    public function completed(Request $request) { return $this->listByStatus($request, 'completed'); }

    private function listByStatus(Request $request, $status)
    {
        $query = Campaign::with(['entity', 'campaignCategory', 'primaryImage'])
            ->where('status', $status);

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $campaigns = $query
            ->latest('updated_at')
            ->paginate(10);

        $categories = CampaignCategory::all();

        if ($request->ajax()) {
            return view('admin.campaigns._table', ['campaigns' => $campaigns, 'context' => $status])->render();
        }

        return view("admin.campaigns.$status", compact('campaigns', 'categories'));
    }

    public function detail($id)
    {
        $campaign = Campaign::with(['entity', 'campaignCategory', 'primaryImage', 'images', 'user'])->findOrFail($id);
        return response()->json($campaign);
    }

    public function updateStatus(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);
        $status = $request->status;
        $data = ['status' => $status];

        if ($status == 'approved') {
            $data['approved_at'] = now();
            $data['approved_by'] = auth()->id();
            $data['is_active'] = true;
        } elseif ($status == 'rejected') {
            $data['rejection_reason'] = $request->reason;
        }

        $campaign->update($data);
        return response()->json(['success' => true]);
    }

    public function toggleActive($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update(['is_active' => !$campaign->is_active]);

        return response()->json([
            'success' => true,
            'new_status' => $campaign->is_active ? 'VISIBLE' : 'INVISIBLE'
        ]);
    }
}