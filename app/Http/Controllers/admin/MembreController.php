<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MembreController extends Controller
{
    public function index()
    {
        $membres = Membre::latest()->paginate(15);
        return view('admin.membre.index', compact('membres'));
    }

    public function create()
    {
        return view('admin.membre.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:membres,email',
            'telephone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('membres', 'public');
        }

        Membre::create($validated);

        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre créé avec succès.');
    }

    public function show(Membre $membre)
    {
        return view('admin.membre.show', compact('membre'));
    }

    public function edit(Membre $membre)
    {
        return view('admin.membre.edit', compact('membre'));
    }

    public function update(Request $request, Membre $membre)
    {
        $validated = $request->validate([
            'fullname' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email|unique:membres,email,' . $membre->id,
            'telephone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($membre->image) {
                Storage::disk('public')->delete($membre->image);
            }
            $validated['image'] = $request->file('image')->store('membres', 'public');
        }

        $membre->update($validated);

        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre mis à jour avec succès.');
    }

    public function destroy(Membre $membre)
    {
        if ($membre->image) {
            Storage::disk('public')->delete($membre->image);
        }

        $membre->delete();

        return redirect()->route('admin.membres.index')
            ->with('success', 'Membre supprimé avec succès.');
    }
}