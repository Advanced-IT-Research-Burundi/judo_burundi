@extends('layouts.user')

@section('title', ($post->title ?? 'Actualité') . ' - Fédération de Judo du Burundi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/actualite.css') }}">
@endpush

@section('content')
    <!-- Section Hero -->
    <section class="hero" id="home">
        <div class="hero-slider">
            <div class="slide active" style="background-image: url('{{ asset('images/judo1.jpeg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/judo2.jpg') }}');"></div>
            <div class="slide" style="background-image: url('{{ asset('images/judo3.jpg') }}');"></div>

            <div class="overlay"></div>

            <div class="hero-content">
                <h1>ENTRAÎNEZ-VOUS AVEC LES MEILLEURS</h1>
                <p>Découvrez le JUDO traditionnel avec nos instructeurs légendaires</p>
                <div class="hero-buttons">
                    <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                    <a href="{{ route('contact.store') }}" class="btn-secondary">En savoir plus</a>
                </div>
            </div>

            <div class="slider-arrows">
                <span class="prev">&#10094;</span>
                <span class="next">&#10095;</span>
            </div>

            <div class="slider-dots"></div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Bouton retour -->
            <div class="back-navigation">
                <a href="{{ route('blog') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Retour aux actualités
                </a>
            </div>

            <div class="article-layout">
                <!-- Article principal -->
                <article class="article-main">
                    <!-- Image -->
                    <div class="article-image">
                        @if($post->image && file_exists(public_path('storage/' . $post->image)))
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        @else
                            <i class="fas fa-newspaper default-icon"></i>
                        @endif
                    </div>

                    <!-- Contenu -->
                    <div class="article-content">
                        <header class="article-header">
                            <div class="article-meta">
                                <div class="meta-item">
                                    <span class="meta-date">
                                        Publié le {{ $post->created_at->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>Admin JUDO</span>
                                </div>
                            </div>

                            <h1 class="article-title">
                                {{ $post->title }}
                            </h1>
                        </header>

                        <div class="article-body">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="sidebar">
                    <!-- Partage -->
                    <div class="sidebar-widget">
                        <h3><i class="fas fa-share-alt"></i> Partager</h3>
                        <div class="share-buttons">
                            <a href="#" class="share-btn share-facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="#" class="share-btn share-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="#" class="share-btn share-linkedin">
                                <i class="fab fa-linkedin-in"></i> LinkedIn
                            </a>
                            <a href="#" class="share-btn share-whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Informations -->
                    <div class="sidebar-widget">
                        <h3><i class="fas fa-info-circle"></i> Informations</h3>
                        <div style="color: #666; line-height: 1.6;">
                            <p><strong>Publié le :</strong> {{ $post->created_at->format('d/m/Y') }}</p>
                            <p><strong>Auteur :</strong> Admin JUDO</p>
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
