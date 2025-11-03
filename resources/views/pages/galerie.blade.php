@extends('layouts.user')

@section('content')
<!-- Page Hero Section - Galerie -->
<section class="page-hero green-overlay" style="background-image: url('{{ asset('images/judo4.jpg') }}');">
    <div class="page-hero-content">
        <h1>Galerie Photos</h1>
        <p>Revivez les meilleurs moments de notre académie</p>
        <div class="page-hero-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <span>Galerie</span>
        </div>
    </div>
</section>

<!-- Contenu de la galerie -->
<section class="gallery-section" style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div class="section-title">
            <h2>Nos Moments Forts</h2>
            <p>Découvrez notre académie en images</p>
        </div>

        <!-- Filtres de galerie -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <button class="filter-btn active" data-filter="all" 
                    style="background: #7CB342; color: white; border: none; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Tout
            </button>
            <button class="filter-btn" data-filter="competition" 
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Compétitions
            </button>
            <button class="filter-btn" data-filter="training" 
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Entraînements
            </button>
            <button class="filter-btn" data-filter="events" 
                    style="background: #f8f9fa; color: #333; border: 2px solid #7CB342; padding: 10px 25px; 
                           margin: 5px; border-radius: 25px; cursor: pointer; font-weight: 600;">
                Événements
            </button>
        </div>

        <!-- Grille de galerie -->
        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
            @forelse($galleryImages as $image)
                <div class="gallery-item" style="position: relative; height: 300px; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.3s;">
                    @if ($image->images && file_exists(public_path('storage/' . $image->images)))
                        <img src="{{ asset('storage/' . $image->images) }}" 
                             alt="Image de la galerie"
                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #7CB342, #689F3A); 
                                    display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 4rem; color: white; opacity: 0.7;"></i>
                        </div>
                    @endif
                    <div class="gallery-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; 
                                                        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); 
                                                        padding: 20px; opacity: 0; transition: opacity 0.3s;">
                        <h4 style="color: white; margin-bottom: 5px;">{{ $image->title ?? 'Photo' }}</h4>
                        <p style="color: #ccc; font-size: 0.9rem;">{{ $image->category ?? 'Galerie' }}</p>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <i class="fas fa-images" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <h3 style="color: #666;">Aucune image disponible</h3>
                    <p style="color: #999;">Les photos seront bientôt ajoutées</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .gallery-item:hover {
        transform: translateY(-5px);
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    .filter-btn:hover, .filter-btn.active {
        background: #7CB342 !important;
        color: white !important;
    }
</style>
@endsection