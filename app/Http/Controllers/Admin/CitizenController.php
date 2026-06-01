<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Citizen;
use Illuminate\Http\Request;

class CitizenController extends Controller
{
    public function index(Request $request)
    {
        $counts = [
            'pending'   => Citizen::where('status', 'pending')->count(),
            'approved'  => Citizen::where('status', 'approved')->count(),
            'rejected'  => Citizen::where('status', 'rejected')->count(),
        ];

        $citizens = Citizen::with(['user'])
            ->latest('updated_at')
            ->paginate(5);

        if ($request->ajax()) {
            return view('admin.citizen._table', ['citizens' => $citizens, 'context' => 'index'])->render();
        }

        return view('admin.citizen.index', compact('counts', 'citizens'));
    }

    public function pending(Request $request)
    {
        return $this->listByStatus($request, 'pending');
    }

    public function approved(Request $request)
    {
        return $this->listByStatus($request, 'approved');
    }

    public function rejected(Request $request)
    {
        return $this->listByStatus($request, 'rejected');
    }

    private function listByStatus(Request $request, $status)
    {
        $query = Citizen::with(['user'])
            ->where('status', $status);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('id_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $citizens = $query
            ->latest('updated_at')
            ->paginate(10);

        if ($request->ajax()) {
            return view('admin.citizen._table', ['citizens' => $citizens, 'context' => $status])->render();
        }

        return view("admin.citizen.$status", compact('citizens'));
    }

    public function detail($id)
    {
        $citizen = Citizen::with(['user', 'verifier'])->findOrFail($id);
        return response()->json($citizen);
    }

    public function updateStatus(Request $request, $id)
    {
        $citizen = Citizen::findOrFail($id);
        $status = $request->status;
        $data = ['status' => $status];

        if ($status == 'approved') {
            $data['verified_at'] = now();
            $data['verified_by'] = auth()->id();
            $data['reject_reason'] = null;

            // Update user status to active when citizen is approved
            $citizen->user->update(['status' => 'active']);
        } elseif ($status == 'rejected') {
            $data['reject_reason'] = $request->reason;
            $data['verified_at'] = null;
            $data['verified_by'] = null;

            // Update user status to inactive when citizen is rejected
            $citizen->user->update(['status' => 'inactive']);
        }

        $citizen->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'new_status' => $status
        ]);
    }
}
