<?php

namespace App\Http\Controllers;
use App\Models\GalleryImage;

use Illuminate\Http\Request;

class GalerieController extends Controller
{
public function index()
{
    // Récupérer les images de la galerie depuis la base
    $galleryImages = GalleryImage::latest()->take(12)->get();

    return view('pages.galerie', compact('galleryImages'));
}
}
