<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;

class GalleryImageController extends Controller
{
    public function index()
    {
        $images = GalleryImage::latest()->paginate(12);
        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'  => 'required|string|max:255',
            'images' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('images')->store('gallery', 'public');

        GalleryImage::create([
            'titre'  => $request->titre,
            'images' => $path,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Image ajoutée avec succès !');
    }

    // === SHOW ===
    public function show(GalleryImage $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    // === EDIT ===
    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    // === UPDATE ===
    public function update(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'titre'  => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = ['titre' => $request->titre];

        if ($request->hasFile('images')) {
            if ($gallery->images && Storage::disk('public')->exists($gallery->images)) {
                Storage::disk('public')->delete($gallery->images);
            }
            $data['images'] = $request->file('images')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image mise à jour avec succès !');
    }

    // === DESTROY ===
    public function destroy(GalleryImage $gallery)
    {
        if ($gallery->images && Storage::disk('public')->exists($gallery->images)) {
            Storage::disk('public')->delete($gallery->images);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Image supprimée avec succès !');
    }
}
