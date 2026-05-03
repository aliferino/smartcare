<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampaignCategory;
use Illuminate\Http\Request;

class CampaignCategoryController extends Controller
{
    public function index()
    {
        $categories = CampaignCategory::latest()->get();
        return view('admin.campaigns.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = CampaignCategory::create($request->all());

        if ($request->wantsJson()) {
            return response()->json($category);
        }
        return back();
    }

    public function update(Request $request, CampaignCategory $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->all());

        if ($request->wantsJson()) {
            return response()->json($category);
        }
        return back();
    }

    public function destroy(CampaignCategory $category)
    {
        // Cek jika kategori masih digunakan oleh campaign manapun[cite: 18]
        if ($category->campaigns()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category that is in use by campaigns.'], 422);
        }
        
        $category->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Deleted']);
        }
        return back();
    }
}