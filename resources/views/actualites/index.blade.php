@extends('layouts.user')

@section('title', ($post->title ?? 'Actualité') . ' - Fédération de Judo du Burundi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/actualite.css') }}">
@endpush

@section('content')
    <!-- Page Hero Section -->
    <section class="page-hero gradient-overlay" style="background-image: url('{{ $post->image ? asset('storage/' . $post->image) : asset('images/judo3.jpg') }}');">
        <div class="page-hero-content">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->content ? Str::limit(strip_tags($post->content), 100) : 'Découvrez cette actualité' }}</p>
            
            <!-- Breadcrumb -->
            <div class="page-hero-breadcrumb">
                <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('blog') }}">Actualités</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $post->title }}</span>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
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