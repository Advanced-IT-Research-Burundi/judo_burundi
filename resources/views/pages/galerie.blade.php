@extends('layouts.user')
@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>NOTRE GALERIE</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            {{-- <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <a href="{{ route('contact.store') }}" class="btn-secondary">En savoir Plus</a>
            </div> --}}
        </div>
    </section>
    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="container">
            <div class="section-title">
                <h2>Galerie Photos</h2>
                <p>Découvrez notre académie en images</p>
            </div>
            <div class="gallery-grid">
                @forelse($galleryImages as $image)
                    <div class="gallery-item">
                        <div
                            style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                            @if ($image->images && file_exists(public_path('storage/' . $image->images)))
                                <img src="{{ asset('storage/' . $image->images) }}" alt="Image de la galerie"
                                    style="height: 100%; width: auto; border-radius: 10px;">
                            @else
                                <i class="fas fa-image" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Aucune image disponible pour le moment.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
