<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::where('user_id', Auth::id())
            ->with('entityCategory')
            ->latest()
            ->paginate(10);

        $categories = EntityCategory::all();

        return view('fundraiser.entities.index', compact('entities', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entity_category_id' => 'required|exists:entity_categories,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'legal_document_path' => 'nullable|file|mimes:pdf,doc,docx,odt,rtf|max:10240',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['is_active'] = false;

        // Upload files
        if ($request->hasFile('logo_path')) {
            $validated['logo_path'] = $request->file('logo_path')->store('entities/logos', 'public');
        }

        if ($request->hasFile('legal_document_path')) {
            $validated['legal_document_path'] = $request->file('legal_document_path')->store('entities/documents', 'public');
        }

        Entity::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Entity created successfully. Waiting for admin approval.'
        ]);
    }

    public function edit(Entity $entity)
    {
        // Check ownership
        if ($entity->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        return response()->json($entity->load('entityCategory'));
    }

    public function detail(Entity $entity)
    {
        // Check ownership
        if ($entity->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        return response()->json($entity->load(['entityCategory', 'user']));
    }

    public function update(Request $request, Entity $entity)
    {
        // Check ownership
        if ($entity->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'entity_category_id' => 'required|exists:entity_categories,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'legal_document_path' => 'nullable|file|mimes:pdf,doc,docx,odt,rtf|max:10240',
        ]);

        // Update slug if name changed
        if ($validated['name'] !== $entity->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }

        // Reset status to pending when updating
        $validated['status'] = 'pending';
        $validated['approved_at'] = null;
        $validated['approved_by'] = null;
        $validated['rejection_reason'] = null;

        // Upload new files if provided
        if ($request->hasFile('logo_path')) {
            if ($entity->logo_path) {
                Storage::disk('public')->delete($entity->logo_path);
            }
            $validated['logo_path'] = $request->file('logo_path')->store('entities/logos', 'public');
        }

        if ($request->hasFile('legal_document_path')) {
            if ($entity->legal_document_path) {
                Storage::disk('public')->delete($entity->legal_document_path);
            }
            $validated['legal_document_path'] = $request->file('legal_document_path')->store('entities/documents', 'public');
        }

        $entity->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Entity updated successfully. Waiting for admin approval.'
        ]);
    }

    public function destroy(Entity $entity)
    {
        // Check ownership
        if ($entity->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        // Check if entity has campaigns
        if ($entity->campaigns()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete entity with existing campaigns.'
            ], 400);
        }

        // Delete files
        if ($entity->logo_path) {
            Storage::disk('public')->delete($entity->logo_path);
        }

        if ($entity->legal_document_path) {
            Storage::disk('public')->delete($entity->legal_document_path);
        }

        $entity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Entity deleted successfully.'
        ]);
    }
}
