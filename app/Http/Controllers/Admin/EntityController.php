<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entity;
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

        $entities = Entity::with(['user', 'entityCategory'])->latest()->paginate(5);

        if ($request->ajax()) {
            return view('admin.entities._table', ['entities' => $entities, 'context' => 'index'])->render();
        }

        return view('admin.entities.index', compact('counts', 'entities'));
    }

    public function pending(Request $request) { 
        return $this->listByStatus($request, 'pending', 'pending'); 
    }

    public function active(Request $request)  { 
        return $this->listByStatus($request, 'approved', 'active'); 
    }

    public function rejected(Request $request) { 
        return $this->listByStatus($request, 'rejected', 'rejected'); 
    }

    private function listByStatus(Request $request, $dbStatus, $viewName)
    {
        $entities = Entity::with(['user', 'entityCategory', 'admin'])
            ->where('status', $dbStatus) 
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.entities._table', ['entities' => $entities, 'context' => $dbStatus])->render();
        }

        return view("admin.entities.$viewName", compact('entities'));
    }

    public function detail($id)
    {
        $entity = Entity::with(['user', 'entityCategory', 'admin'])->findOrFail($id);
        return response()->json($entity);
    }

    public function updateStatus(Request $request, $id)
    {
        $entity = Entity::findOrFail($id);
        $data = ['status' => $request->status];
        
        if ($request->status == 'approved') {
            $data['approved_at'] = now();
            $data['approved_by'] = auth()->id();
        } else {
            $data['rejection_reason'] = $request->reason;
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
            'new_status' => $entity->is_active ? 'ACTIVE' : 'INACTIVE'
        ]);
    }
}