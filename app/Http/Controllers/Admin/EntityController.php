<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityCategory;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function index(Request $request)
    {
        $counts = [
            'pending'  => Entity::where('status', 'pending')->count(),
            'approved' => Entity::where('status', 'approved')->count(),
            'rejected' => Entity::where('status', 'rejected')->count(),
        ];

        $entities = Entity::with(['user', 'entityCategory'])
            ->latest() 
            ->paginate(5);

        if ($request->ajax()) {
            return view('admin.entities._table', ['entities' => $entities, 'context' => 'index'])->render();
        }

        return view('admin.entities.index', compact('counts', 'entities'));
    }

    public function pending(Request $request)  { return $this->listByStatus($request, 'pending'); }
    public function approved(Request $request) { return $this->listByStatus($request, 'approved'); }
    public function rejected(Request $request) { return $this->listByStatus($request, 'rejected'); }

    private function listByStatus(Request $request, $status)
    {
        $query = Entity::with(['user', 'entityCategory', 'admin'])
            ->where('status', $status);

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('entity_category_id', $request->category);
        }

        $entities = $query->
            latest('updated_at')
            ->paginate(10);

        $categories = EntityCategory::all();
        
        if ($request->ajax()) {
            return view('admin.entities._table', ['entities' => $entities, 'context' => $status])->render();
        }

        return view("admin.entities.$status", compact('entities', 'categories'));
    }

    public function detail($id)
    {
        $entity = Entity::with(['user', 'entityCategory', 'admin'])->findOrFail($id);
        return response()->json($entity);
    }

    public function updateStatus(Request $request, $id)
    {
        $entity = Entity::findOrFail($id);
        $status = $request->status; 
        $data = ['status' => $status];
        
        if ($status == 'approved') {
            $data['approved_at'] = now();
            $data['approved_by'] = auth()->id();
            $data['is_active'] = true; 
        } else {
            $data['rejection_reason'] = $request->reason;
            $data['is_active'] = true;
        }

        $entity->update($data);
        return response()->json(['success' => true]);
    }

    public function toggleActive($id)
    {
        $entity = Entity::findOrFail($id);
        $entity->update([
            'is_active' => !$entity->is_active
        ]);

        return response()->json([
            'success' => true,
            'new_status' => $entity->is_active ? 'VISIBLE' : 'INVISIBLE'
        ]);
    }
}