<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EntityCategory;
use Illuminate\Http\Request;

class EntityCategoryController extends Controller
{
    public function index()
    {
        $categories = EntityCategory::latest()->get();
        return view('admin.entities.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = EntityCategory::create($request->all());

        if ($request->wantsJson()) {
   
            return response()->json($category);
        }
        return back();
    }

    public function update(Request $request, EntityCategory $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category->update($request->all());

        if ($request->wantsJson()) {
            
            return response()->json($category);
        }
        return back();
    }

    public function destroy(EntityCategory $category)
    {
        if ($category->entities()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category that is in use.'], 422);
        }
        
        $category->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Deleted']);
        }
        return back();
    }
}