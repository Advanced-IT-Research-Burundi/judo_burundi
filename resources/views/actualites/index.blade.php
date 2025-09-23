@extends('layouts.user')

@section('title', ($actualite->titre ?? 'Actualité') . ' - Fédération de Judo du Burundi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/actualite.css') }}">
@endpush
    <section class="hero" id="home">
        <div class="container">
            <h1>Nos Actualites</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
               <a href="{{route('contact.store')}}">En savoir Plus</a>
            </div>
        </div>
    </section>
@section('content')
    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Breadcrumb -->
            {{-- <div class="breadcrumb">
                <nav class="breadcrumb-nav">
                    <a href="{{ route('home') }}">Accueil</a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('blog') }}">Actualités</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>{{ Str::limit($actualite->titre ?? 'Actualité', 50) }}</span>
                </nav>
            </div> --}}

            <!-- Back Navigation -->
            <div class="back-navigation">
                <a href="{{ route('blog') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Retour aux actualités
                </a>
            </div>

            <!-- Article Layout -->
            <div class="article-layout">
                <!-- Article Main -->
                <article class="article-main">
                    <!-- Article Image -->
                    <div class="article-image">
                        @if($actualite->image && file_exists(public_path('storage/' . $actualite->image)))
                            <img src="{{ asset('storage/' . $actualite->image) }}" alt="{{ $actualite->titre }}">
                        @else
                            @php
                                $icons = [
                                    'Compétition' => 'fas fa-trophy',
                                    'Événement' => 'fas fa-calendar-alt',
                                    'Formation' => 'fas fa-graduation-cap',
                                    'Résultats' => 'fas fa-chart-line',
                                    'Annonce' => 'fas fa-bullhorn'
                                ];
                                $categoryName = $actualite->typePost->nom ?? 'Actualité';
                                $icon = $icons[$categoryName] ?? 'fas fa-newspaper';
                            @endphp
                            <i class="{{ $icon }} default-icon"></i>
                        @endif
                    </div>

                    <!-- Article Content -->
                    <div class="article-content">
                        <!-- Article Header -->
                        <header class="article-header">
                            <div class="article-meta">
                                <div class="meta-item">
                                    <span class="meta-date">
                                        {{ $actualite->date_post ? \Carbon\Carbon::parse($actualite->date_post)->format('d M Y') : now()->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-category">
                                        {{ $actualite->typePost->nom ?? 'Actualité' }}
                                    </span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $actualite->user->name ?? $actualite->auteur ?? 'Admin JUDO' }}</span>
                                </div>
                                @if(isset($actualite->vues))
                                    <div class="meta-item">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ $actualite->vues ?? '0' }} vues</span>
                                    </div>
                                @endif
                            </div>

                            <h1 class="article-title">
                                {{ $actualite->titre ?? 'Titre de l\'actualité' }}
                            </h1>

                            @if($actualite->extrait)
                                <div class="article-excerpt">
                                    {{ $actualite->extrait }}
                                </div>
                            @endif
                        </header>

                        <!-- Article Body -->
                        <div class="article-body">
                            {!! $actualite->contenu ?? '<p>Contenu de l\'actualité non disponible.</p>' !!}
                        </div>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="sidebar">
                    <!-- Share Widget -->
                    <div class="sidebar-widget">
                        <h3><i class="fas fa-share-alt"></i> Partager</h3>
                        <div class="share-buttons">
                            <a href="#" class="share-btn share-facebook">
                                <i class="fab fa-facebook-f"></i>
                                Facebook
                            </a>
                            <a href="#" class="share-btn share-twitter">
                                <i class="fab fa-twitter"></i>
                                Twitter
                            </a>
                            <a href="#" class="share-btn share-linkedin">
                                <i class="fab fa-linkedin-in"></i>
                                LinkedIn
                            </a>
                            <a href="#" class="share-btn share-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                    <!-- Quick Info -->
                    <div class="sidebar-widget">
                        <h3><i class="fas fa-info-circle"></i> Informations</h3>
                        <div style="color: #666; line-height: 1.6;">
                            <p><strong>Publié le :</strong> {{ $actualite->date_post ? \Carbon\Carbon::parse($actualite->date_post)->format('d/m/Y') : 'Non spécifié' }}</p>
                            <p><strong>Catégorie :</strong> {{ $actualite->typePost->nom ?? 'Non classé' }}</p>
                            <p><strong>Auteur :</strong> {{ $actualite->user->name ?? $actualite->auteur ?? 'Admin JUDO' }}</p>
                            @if(isset($actualite->vues))
                                <p><strong>Vues :</strong> {{ $actualite->vues ?? '0' }}</p>
                            @endif
                        </div>
                        <div style="margin-top: 1rem;">
                            <a href="{{ route('contact') }}" class="back-btn" style="display: block; text-align: center; text-decoration: none;">
                                Plus d'infos
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/actualite.js') }}"></script>
@endpush