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
        $campaigns = Campaign::where('user_id', Auth::id())
            ->with(['entity', 'campaignCategory'])
            ->latest()
            ->paginate(10);

        $entities = Entity::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->where('is_active', true)
            ->get();

        $categories = CampaignCategory::all();

        return view('fundraiser.campaigns.index', compact('campaigns', 'entities', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'category_id' => 'required|exists:campaign_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_urgent' => 'boolean',
            'goal_amount' => 'required|numeric|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Verify entity ownership
        $entity = Entity::where('id', $validated['entity_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->first();

        if (!$entity) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid entity selected.'
            ], 403);
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['is_active'] = true;
        $validated['current_amount'] = 0;
        $validated['donors_count'] = 0;
        $validated['is_urgent'] = $request->has('is_urgent') ? true : false;

        $campaign = Campaign::create($validated);

        // Upload image (required)
        $imagePath = $request->file('image')->store('campaigns/images', 'public');
        $campaign->images()->create([
            'image_path' => $imagePath,
            'is_primary' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Campaign created successfully. Waiting for admin approval.'
        ]);
    }

    public function edit(Campaign $campaign)
    {
        // Check ownership
        if ($campaign->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Check if campaign can be edited
        if ($campaign->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit completed campaign.'
            ], 403);
        }

        if ($campaign->donors_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit campaign that already has donations.'
            ], 403);
        }

        return response()->json($campaign->load(['entity', 'campaignCategory', 'primaryImage']));
    }

    public function detail(Campaign $campaign)
    {
        // Check ownership
        if ($campaign->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        return response()->json($campaign->load(['entity', 'campaignCategory', 'primaryImage', 'user']));
    }

    public function update(Request $request, Campaign $campaign)
    {
        // Check ownership
        if ($campaign->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Check if campaign can be edited
        if ($campaign->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit completed campaign.'
            ], 403);
        }

        if ($campaign->donors_count > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit campaign that already has donations.'
            ], 403);
        }

        $validated = $request->validate([
            'entity_id' => 'required|exists:entities,id',
            'category_id' => 'required|exists:campaign_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_urgent' => 'boolean',
            'goal_amount' => 'required|numeric|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Verify entity ownership
        $entity = Entity::where('id', $validated['entity_id'])
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->first();

        if (!$entity) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid entity selected.'
            ], 403);
        }

        // Update slug if title changed
        if ($validated['title'] !== $campaign->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        // Reset status to pending when updating
        $validated['status'] = 'pending';
        $validated['approved_at'] = null;
        $validated['approved_by'] = null;
        $validated['rejection_reason'] = null;
        $validated['is_urgent'] = $request->has('is_urgent') ? true : false;

        $campaign->update($validated);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old primary image if exists
            $oldImage = $campaign->images()->where('is_primary', true)->first();
            if ($oldImage) {
                \Storage::disk('public')->delete($oldImage->image_path);
                $oldImage->delete();
            }

            // Upload new image
            $imagePath = $request->file('image')->store('campaigns/images', 'public');
            $campaign->images()->create([
                'image_path' => $imagePath,
                'is_primary' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Campaign updated successfully. Waiting for admin approval.'
        ]);
    }

    public function destroy(Campaign $campaign)
    {
        // Check ownership
        if ($campaign->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Check if campaign has donations
        if ($campaign->donations()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete campaign with existing donations.'
            ], 400);
        }

        $campaign->delete();

        return response()->json([
            'success' => true,
            'message' => 'Campaign deleted successfully.'
        ]);
    }
}