@extends('layouts.user')
@section('content')
@section('title', 'Blog & Actualités')
<!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>NOS ACTUALITES</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            {{-- <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <a href="{{ route('contact.store') }}" class="btn-secondary">En savoir Plus</a>
            </div> --}}
        </div>
    </section>
<!-- News Section -->
<section class="news" id="news">
    <div class="container">
        <div class="news-header">
            <div class="section-title" style="text-align: left; margin-bottom: 0;">
                <h2>Actualités</h2>
                <p>Restez informés de toutes nos actualités</p>
            </div>
        </div>

        <!-- News Grid -->
        <div id="newsGrid" class="news-grid">
            @forelse($actualites as $actualite)
                <div class="news-card">
                    <div class="news-image">
                        @if ($actualite->image && file_exists(public_path('storage/' . $actualite->image)))
                            <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}"
                                style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                        @else
                            <!-- Image par défaut selon le type -->
                            @switch($actualite->typePost->nom ?? 'default')
                                @case('Compétition')
                                    <img src="/images/judo3.jpg" alt="Compétition"
                                        style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                @break

                                @case('Événement')
                                    <img src="/images/judo4.jpg" alt="Événement"
                                        style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                @break

                                @case('Formation')
                                    <img src="/images/judo5.jpg" alt="Formation"
                                        style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                                @break

                                @default
                                    <img src="/images/judo6.jpg" alt="Actualité"
                                        style="height: 100%; width: 100%; object-fit: cover; border-radius: 10px;">
                            @endswitch
                        @endif
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date">{{ $actualite->date_post->format('d M Y') }}</span>
                            <span class="news-category">{{ $actualite->typePost->nom ?? 'Actualité' }}</span>
                        </div>
                        <h3 class="news-title">{{ Str::limit($actualite->titre, 60) }}</h3>
                        <p class="news-excerpt">
                            {{ $actualite->extrait ?? Str::limit(strip_tags($actualite->contenu), 120) }}</p>
                            <a href="{{ route('actualites', $actualite->id) }}" class="read-more" style="text-decoration: none">
                                <i class="fas fa-arrow-right"></i> Lire plus
                            </a>
                    </div>
                </div>
                @empty
                    <!-- Affichage si aucune actualité -->
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune actualité pour le moment</h5>
                        <p class="text-muted">Revenez bientôt pour découvrir nos dernières nouvelles !</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
