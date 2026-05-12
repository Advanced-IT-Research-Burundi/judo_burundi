<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
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
        $competitions = Competition::query()->orderByDesc('date_competition')->limit(100)->get();

        return view('admin.gallery.create', compact('competitions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'images' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'competition_id' => 'nullable|exists:competitions,id',
        ]);

        $path = $request->file('images')->store('gallery', 'public');

        GalleryImage::create([
            'titre' => $request->titre,
            'images' => $path,
            'competition_id' => $request->competition_id,
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
        $competitions = Competition::query()->orderByDesc('date_competition')->limit(100)->get();

        return view('admin.gallery.edit', compact('gallery', 'competitions'));
    }

    // === UPDATE ===
    public function update(Request $request, GalleryImage $gallery)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'competition_id' => 'nullable|exists:competitions,id',
        ]);

        $data = ['titre' => $request->titre, 'competition_id' => $request->competition_id];

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
