<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Http\Requests\GalleryImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryImageController extends Controller
{
        public function index(Request $request)
    {
        $query = GalleryImage::query();

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('lieu', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('categorie')) {
            $query->where('categorie', $request->categorie);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $images = $query->ordered()->paginate(15);
        $categories = GalleryImage::getCategories();
        $statuts = GalleryImage::getStatuts();

        return view('admin.gallery.index', compact('images', 'categories', 'statuts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = GalleryImage::getCategories();
        $statuts = GalleryImage::getStatuts();

        return view('admin.gallery.create', compact('categories', 'statuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryImageRequest $request)
    {
        $validated = $request->validated();

        // Upload de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['titre']) . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $image->storeAs('gallery', $filename, 'public');
        }

        // Générer alt_text si vide
        if (empty($validated['alt_text'])) {
            $validated['alt_text'] = $validated['titre'];
        }

        $galleryImage = GalleryImage::create($validated);

        return redirect()
            ->route('admin.gallery.show', $galleryImage)
            ->with('success', 'Image ajoutée avec succès à la galerie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GalleryImage $galleryImage)
    {
        return view('admin.gallery.show', compact('galleryImage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryImage $galleryImage)
    {
        $categories = GalleryImage::getCategories();
        $statuts = GalleryImage::getStatuts();

        return view('pages.gallery.edit', compact('galleryImage', 'categories', 'statuts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryImageRequest $request, GalleryImage $galleryImage)
    {
        $validated = $request->validated();

        // Upload de la nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($galleryImage->image && Storage::disk('public')->exists($galleryImage->image)) {
                Storage::disk('public')->delete($galleryImage->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($validated['titre']) . '.' . $image->getClientOriginalExtension();
            $validated['image'] = $image->storeAs('gallery', $filename, 'public');
        }

        // Générer alt_text si vide
        if (empty($validated['alt_text'])) {
            $validated['alt_text'] = $validated['titre'];
        }

        $galleryImage->update($validated);

        return redirect()
            ->route('admin.gallery.show', $galleryImage)
            ->with('success', 'Image modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GalleryImage $galleryImage)
    {
        $titre = $galleryImage->titre;
        
        // Supprimer l'image du stockage
        if ($galleryImage->image && Storage::disk('public')->exists($galleryImage->image)) {
            Storage::disk('public')->delete($galleryImage->image);
        }

        $galleryImage->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Image "' . $titre . '" supprimée avec succès.');
    }

    /**
     * Toggle status of the image
     */
    public function toggleStatus(GalleryImage $galleryImage)
    {
        $newStatus = $galleryImage->statut === 'actif' ? 'inactif' : 'actif';
        $galleryImage->update(['statut' => $newStatus]);

        $message = $newStatus === 'actif' ? 'Image activée avec succès.' : 'Image désactivée avec succès.';

        return redirect()
            ->back()
            ->with('success', $message);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'images' => 'required|array|min:1',
            'images.*' => 'exists:gallery_images,id'
        ]);

        $images = GalleryImage::whereIn('id', $request->images)->get();
        $count = $images->count();

        switch ($request->action) {
            case 'delete':
                foreach ($images as $image) {
                    if ($image->image && Storage::disk('public')->exists($image->image)) {
                        Storage::disk('public')->delete($image->image);
                    }
                    $image->delete();
                }
                $message = "$count image(s) supprimée(s) avec succès.";
                break;

            case 'activate':
                $images->each(function ($image) {
                    $image->update(['statut' => 'actif']);
                });
                $message = "$count image(s) activée(s) avec succès.";
                break;

            case 'deactivate':
                $images->each(function ($image) {
                    $image->update(['statut' => 'inactif']);
                });
                $message = "$count image(s) désactivée(s) avec succès.";
                break;
        }

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', $message);
    }

    /**
     * Update image order via AJAX
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*.id' => 'required|exists:gallery_images,id',
            'images.*.ordre' => 'required|integer|min:0'
        ]);

        foreach ($request->images as $imageData) {
            GalleryImage::where('id', $imageData['id'])
                ->update(['ordre' => $imageData['ordre']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Ordre des images mis à jour avec succès.'
        ]);
    }
}
