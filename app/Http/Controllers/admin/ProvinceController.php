<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;

class ProvinceController extends Controller
{
        public function index()
    {
        $provinces = Province::withCount(['communes'])->paginate(15);
        return view('admin.province.index', compact('provinces'));
    }

    public function create()
    {
        return view('admin.province.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:provinces',
        ]);

        Province::create($request->all());

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province créée avec succès.');
    }

    public function show(Province $province)
    {
        $province->load(['communes.zones.quartiers']);
        return view('admin.province.show', compact('province'));
    }

    public function edit(Province $province)
    {
        return view('admin.province.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:provinces,nom,' . $province->id,
        ]);

        $province->update($request->all());

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province mise à jour avec succès.');
    }

    public function destroy(Province $province)
    {
        if ($province->communes()->count() > 0) {
            return redirect()->route('admin.provinces.index')
                ->with('error', 'Impossible de supprimer cette province car elle contient des communes.');
        }

        $province->delete();

        return redirect()->route('admin.provinces.index')
            ->with('success', 'Province supprimée avec succès.');
    }
}
