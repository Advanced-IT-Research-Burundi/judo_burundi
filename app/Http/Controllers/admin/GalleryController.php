<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
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
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('images')) {
            $validated['images'] = $request->file('images')->store('gallery', 'public');
        }

        GalleryImage::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image ajoutée à la galerie avec succès.');
    }

    public function show(GalleryImage $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('images')) {
            if ($gallery->images) {
                Storage::disk('public')->delete($gallery->images);
            }
            $validated['images'] = $request->file('images')->store('gallery', 'public');
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image mise à jour avec succès.');
    }

    public function destroy(GalleryImage $gallery)
    {
        if ($gallery->images) {
            Storage::disk('public')->delete($gallery->images);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Image supprimée avec succès.');
    }
}