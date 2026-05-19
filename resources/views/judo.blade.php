@extends('layouts.user')

@section('title', 'Académie de Judo - Fédération Burundaise de Judo et Disciplines Associées')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@include('partials.contact-styles')
@endpush

@php
    $homeFeatures = [
        ['icon' => 'fa-fist-raised', 'title' => 'Techniques', 'body' => 'Apprenez avec des cadres techniques expérimentés.'],
        ['icon' => 'fa-users', 'title' => 'Communauté', 'body' => 'Un club bienveillant pour tous les âges.'],
        ['icon' => 'fa-trophy', 'title' => 'Compétitions', 'body' => 'Calendrier national et rencontres interclubs.'],
    ];
@endphp

@section('content')
    <!-- Hero avec carrousel d’images -->
    <section class="hero" aria-label="Introduction">
        <div class="hero-slider" role="region" aria-roledescription="carrousel" aria-label="Photos de la Fédération">
            <div class="slide active" aria-hidden="true" style="background-image: url('{{ asset('images/judo1.jpeg') }}');"></div>
            <div class="slide" aria-hidden="true" style="background-image: url('{{ asset('images/judo2.jpg') }}');"></div>
            <div class="slide" aria-hidden="true" style="background-image: url('{{ asset('images/judo3.jpg') }}');"></div>

            <div class="overlay" aria-hidden="true"></div>

            <div class="hero-content">
                <h1 class="text-uppercase">Entraînez-vous avec les meilleurs</h1>
                <p>Découvrez le judo traditionnel avec nos instructeurs légendaires.</p>
                <div class="hero-buttons gap-3">
                    <button type="button" class="btn btn-success btn-lg rounded-pill px-4 shadow" onclick="JudoApp.openModal()">
                        <i class="fas fa-play-circle me-2" aria-hidden="true"></i>
                        Commencer maintenant
                    </button>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="fas fa-info-circle me-2" aria-hidden="true"></i>
                        En savoir plus
                    </a>
                </div>
            </div>

            <div class="slider-arrows">
                <button type="button" class="slider-nav-btn prev" aria-label="Image précédente">&#10094;</button>
                <button type="button" class="slider-nav-btn next" aria-label="Image suivante">&#10095;</button>
            </div>

            <div class="slider-dots" aria-label="Choix des images du carrousel"></div>
        </div>
    </section>

    <!-- Bloc « Pourquoi le judo » -->
    <section class="features py-5 bg-body-secondary" aria-labelledby="home-features-heading">
        <div class="container py-lg-2">
            <div class="text-center mb-5">
                <h2 id="home-features-heading" class="h3 fw-bold text-primary text-uppercase">Pourquoi le judo&nbsp;?</h2>
                <p class="text-muted mb-0 col-lg-8 mx-auto">Technique, communauté et compétition au sein de la Fédération.</p>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($homeFeatures as $feat)
                    <div class="col">
                        <div class="feature-card card h-100 border-0 shadow-sm text-center p-4">
                            <div class="card-body">
                                <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3" style="width:3.5rem;height:3.5rem;" aria-hidden="true">
                                    <i class="fas {{ $feat['icon'] }} fa-lg"></i>
                                </div>
                                <h3 class="h5 fw-bold">{{ $feat['title'] }}</h3>
                                <p class="text-muted small mb-0">{{ $feat['body'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Galerie -->
    <section class="gallery py-5" aria-labelledby="home-gallery-heading">
        <div class="container">
            <div class="text-center mb-5">
                <h2 id="home-gallery-heading" class="h3 fw-bold text-primary">Galerie</h2>
                <p class="text-muted mb-2">Images de nos activités</p>
                <p class="mb-0">
                    <a href="{{ route('galerie') }}" class="btn btn-outline-success btn-sm rounded-pill">
                        Voir la galerie complète <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i>
                    </a>
                </p>
            </div>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3 home-gallery-grid">
                @forelse($galleryImages as $image)
                    <div class="col">
                        <a href="{{ route('galerie') }}" class="home-gallery-thumb home-enter-animate d-block rounded-3 shadow-sm border border-light overflow-hidden bg-body-secondary text-decoration-none">
                            <div class="ratio ratio-1x1">
                                <div class="home-gallery-thumb-inner position-relative w-100 h-100">
                                    @if ($galleryThumbUrl = \App\Support\PublicStorageAsset::url($image->images))
                                        <img src="{{ $galleryThumbUrl }}"
                                             class="home-gallery-thumb-img position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                             alt="{{ $image->titre ?? 'Photo — galerie judo Burundi' }}"
                                             loading="lazy"
                                             decoding="async">
                                        <div class="home-gallery-thumb-overlay position-absolute bottom-0 start-0 end-0 d-flex align-items-end p-2 p-sm-3">
                                            <span class="home-gallery-thumb-title text-white small fw-semibold text-truncate w-100">{{ Str::limit($image->titre ?? 'Galerie', 48) }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100 bg-body-secondary text-muted" aria-hidden="true">
                                            <i class="fas fa-image fa-2x opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0" role="status">
                            <i class="fas fa-images fa-2x text-muted mb-2 d-block" aria-hidden="true"></i>
                            Aucune image pour le moment.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Actualités -->
    <section class="news py-5 bg-body-secondary" aria-labelledby="home-news-heading">
        <div class="container">
            <div class="text-center mb-5">
                <h2 id="home-news-heading" class="h3 fw-bold text-primary">Actualités</h2>
                <p class="text-muted mb-0">Dernières nouvelles de la Fédération</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @forelse($actualites as $actualite)
                    <div class="col">
                        <article class="news-card card h-100 border-0 shadow-sm overflow-hidden">
                            <div class="ratio ratio-16x9 bg-body-secondary flex-shrink-0">
                                @if ($postImgUrl = \App\Support\PublicStorageAsset::url($actualite->image ?? null))
                                    <img src="{{ $postImgUrl }}"
                                         class="object-fit-cover w-100 h-100"
                                         alt="{{ $actualite->titre }}"
                                         loading="lazy">
                                @else
                                    @php
                                        $defaultImages = [
                                            'Compétition' => 'judo3.jpg',
                                            'Événement' => 'judo4.jpg',
                                            'Formation' => 'judo5.jpg',
                                            'default' => 'judo6.jpg',
                                        ];
                                        $typeNom = optional($actualite->typePost)->nom;
                                        $imageFile = $defaultImages[$typeNom] ?? $defaultImages['default'];
                                    @endphp
                                    <img src="{{ asset('images/' . $imageFile) }}"
                                         class="object-fit-cover w-100 h-100"
                                         alt="{{ $typeNom ?? 'Actualité' }}"
                                         loading="lazy">
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="h6 card-title fw-bold">{{ Str::limit($actualite->titre, 60) }}</h3>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ $actualite->extrait ?? Str::limit(strip_tags($actualite->contenu), 120) }}
                                </p>
                                <a href="{{ route('actualites', $actualite->id) }}" class="btn btn-outline-success btn-sm align-self-start mt-2 stretched-link">
                                    Lire plus <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center mb-0" role="status">
                            <i class="fas fa-newspaper fa-2x text-muted mb-2 d-block" aria-hidden="true"></i>
                            <strong>Aucune actualité</strong>
                            <p class="text-muted small mb-0">Revenez bientôt pour les dernières nouvelles.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($actualites->count() >= 6)
                <div class="text-center mt-5">
                    <a href="{{ route('blog') }}" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus-circle me-2" aria-hidden="true"></i>Voir toutes les actualités
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Contact (même formulaire que la page Contact) -->
    <section id="contact-accueil" class="registration py-5 bg-white" aria-labelledby="home-contact-heading">
        <div class="container">
            <header class="text-center mb-5">
                <h2 id="home-contact-heading" class="h3 fw-bold text-primary text-uppercase">Contactez la FBUJA</h2>
                <p class="text-muted mb-0 col-xl-10 mx-auto">
                    Écrivez-nous depuis cette page&nbsp;: le formulaire est le même que sur la rubrique <a href="{{ route('contact') }}">Contact</a> (avec carte et tous les détails).
                </p>
            </header>

            {{-- Les messages succès / erreur sont déjà affichés en haut de page dans layouts/user --}}

            <div class="row g-5 align-items-start">
                <div class="col-lg-6">
                    @include('partials.contact-coordonnees', ['showSocialLinks' => false])
                    <p class="text-muted small mt-4 mb-0 border-start border-success border-3 ps-3">
                        <i class="fas fa-map-marker-alt me-2 text-success" aria-hidden="true"></i>
                        Consulter également la carte sur la page <a href="{{ route('contact') }}">Contact complète</a>.
                    </p>
                </div>
                <div class="col-lg-6">
                    @include('partials.contact-form', ['idSuffix' => '_home'])
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endpush
