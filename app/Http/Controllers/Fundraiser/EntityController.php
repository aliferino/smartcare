<?php

namespace App\Http\Controllers\Fundraiser;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntityController extends Controller
{
    public function index()
    {
        $entities = Entity::where('user_id', Auth::id())->latest()->get();
        return view('fundraiser.entity-list', compact('entities'));
    }

    public function create()
    {
        $categories = EntityCategory::all();
        return view('fundraiser.entity-add', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'entity_category_id'  => 'required|exists:entity_categories,id',
            'name'                => 'required|string|max:255',
            'email'               => 'required|email',
            'address'             => 'required|string',
            'logo'                => 'required|image|max:1024',
            'legal_document'      => 'required|mimes:pdf,jpg,png|max:5120',
        ]);

        $logoPath = $request->file('logo')->store('entities/logos', 'public');
        $docPath  = $request->file('legal_document')->store('entities/documents', 'public');

        Entity::create([
            'user_id'             => Auth::id(),
            'entity_category_id'  => $request->entity_category_id,
            'name'                => $request->name,
            'email'               => $request->email,
            'address'             => $request->address,
            'logo_path'           => $logoPath,
            'legal_document_path' => $docPath,
            'status'              => 'pending',
        ]);

        return redirect()->route('fundraiser.entities.index')->with('success', 'Lembaga berhasil didaftarkan, tunggu verifikasi admin.');
    }

    public function destroy(Entity $entity)
    {
        if ($entity->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki otoritas atas lembaga ini.');
        }

        if ($entity->campaigns()->exists()) {
            return back()->with('error', 'Lembaga tidak bisa dihapus karena memiliki campaign yang sedang atau pernah berjalan.');
        }

        if ($entity->logo_path) {
            \Storage::disk('public')->delete($entity->logo_path);
        }

        if ($entity->legal_document_path) {
            \Storage::disk('public')->delete($entity->legal_document_path);
        }

        $entity->delete();

        return redirect()->route('fundraiser.entities.index')->with('success', 'Lembaga berhasil dihapus.');
    }
}