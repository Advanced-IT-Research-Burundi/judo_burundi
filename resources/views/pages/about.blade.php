@extends('layouts.user')
@section('content')
@section('title', 'A Propos de nous')

<!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h1>A PROPOS DE NOUS</h1>
            <p>Découvrez JUDO traditionnel avec nos instructeurs légendaires</p>
            {{-- <div class="hero-buttons">
                <button class="btn-primary" onclick="openModal()">Commencer maintenant</button>
                <a href="{{ route('contact.store') }}" class="btn-secondary">En savoir Plus</a>
            </div> --}}
        </div>
    </section>
<!-- Welcome Section -->
<section class="welcome" id="about">
    <div class="container">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Bienvenue dans notre Académie</h2>
                <p>Notre académie de judo Burundi offre un enseignement de qualité supérieure dans un environnement
                    respectueux et discipliné. Nous accueillons tous les niveaux, des débutants aux avancés.</p>
                <p>Avec plus de 20 ans d'expérience, nos instructeurs vous guideront dans votre parcours, que ce
                    soit pour la self-défense, la compétition ou le développement personnel.</p>
                {{-- <button class="btn-primary" onclick="openModal()">Rejoignez-nous</button> --}}
            </div>
            <div class="welcome-image">
                <div
                    style="height: 400px; background: #ddd; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #666;">
                    {{-- <i class="fas fa-image" style="font-size: 4rem;"></i> --}}
                    <img src="/images/judo2.jpg" alt="Welcome Image"
                        style="height: 100%; width: auto; border-radius: 10px;">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="instructors" id="instructors">
    <div class="container">
        <div class="section-title">
            <h2>Notre équipe</h2>
            <p>Rencontrez nos maîtres expérimentés</p>
        </div>
        <div class="instructors-grid">
            @forelse($equipes as $membre)
                <div class="instructor-card">
                    <div class="instructor-image">
                        <div style="height: 100%; background: #ddd; display: flex; align-items: center; justify-content: center; color: #666;">
                            @if($membre->photo)
                                <img src="{{ asset('storage/'.$membre->photo) }}" alt="{{ $membre->fullname }}" style="height: 100%; width: auto; border-radius: 10px;">
                            @else
                                <i class="fas fa-user" style="font-size: 3rem;"></i>
                            @endif
                        </div>
                    </div>
                    <div class="instructor-info">
                        <h3>{{ $membre->fullname }}</h3>
                        <p>{{ $membre->poste ?? 'Poste non précisé' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Aucun membre trouvé pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
