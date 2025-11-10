@extends('layouts.user')

@section('title', 'Direction - Fédération de Judo du Burundi')

@section('content')
<!-- HERO SECTION -->
<section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo1.jpeg') }}');">
    <div class="page-hero-content text-center">
        <h1>Direction</h1>
        <p>Les membres du comité exécutif de la Fédération Burundaise de Judo</p>
    </div>
</section>

<!-- DIRECTION SECTION -->
<section class="direction-section py-5">
    <div class="container">
        <!-- TITRE SECTION -->
        <div class="text-center mb-5">
            <h2 class="section-title-main">Le Bureau Fédéral</h2>
            <p class="section-subtitle">Fédération Burundaise de Judo et Disciplines Associées</p>
            <div class="title-underline-center"></div>
        </div>

        <!-- MEMBRES DU COMITÉ -->
        <div class="row g-4 justify-content-center">
            @forelse($equipes as $index => $membre)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="member-card">
                        <div class="member-image">
                            @if($membre->photo)
                                <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->fullname }}">
                            @else
                                <img src="{{ asset('images/default-user.png') }}" alt="Photo par défaut">
                            @endif
                            <div class="member-overlay">
                                <i class="fas fa-user-tie"></i>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4 class="member-name">{{ $membre->fullname }}</h4>
                            <p class="member-role">{{ $membre->poste ?? 'Membre du Bureau' }}</p>
                            @if($membre->email || $membre->telephone)
                                <div class="member-contact">
                                    @if($membre->email)
                                        <a href="mailto:{{ $membre->email }}" title="Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    @endif
                                    @if($membre->telephone)
                                        <a href="tel:{{ $membre->telephone }}" title="Téléphone">
                                            <i class="fas fa-phone"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Aucun membre du comité exécutif n'est disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- MISSION SECTION -->
        <div class="mission-box mt-5">
            <div class="row align-items-center">
                <div class="col-md-8 mx-auto">
                    <div class="mission-content text-center">
                        <div class="mission-icon mb-3">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="mission-title">Notre Mission</h3>
                        <p class="mission-text">
                            Le comité exécutif travaille en étroite collaboration avec les clubs affiliés, 
                            les entraîneurs et les athlètes pour promouvoir le judo et assurer son développement 
                            à travers tout le pays. Ensemble, nous formons les champions de demain tout en 
                            transmettant les valeurs fondamentales du judo : courtoisie, courage, honnêteté, 
                            honneur, modestie, respect, maîtrise de soi et amitié.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* STYLES SPÉCIFIQUES À LA PAGE DIRECTION */

    /* HERO SECTION */
    .page-hero {
        position: relative;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .gradient-overlay::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* background: linear-gradient(135deg, rgba(102, 126, 234, 0.85) 0%, rgba(118, 75, 162, 0.85) 100%); */
    }

    .page-hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }

    .page-hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    }

    .page-hero-content p {
        font-size: 1.3rem;
        font-weight: 300;
        text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
    }

    /* DIRECTION SECTION */
    .direction-section {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    /* SECTION TITLE */
    .section-title-main {
        font-size: 2.8rem;
        font-weight: 800;
        color: #1a365d;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        font-size: 1.2rem;
        color: #4a5568;
        margin-bottom: 1.5rem;
    }

    .title-underline-center {
        width: 100px;
        height: 4px;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        margin: 0 auto;
        border-radius: 2px;
    }

    /* MEMBER CARDS */
    .member-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        height: 100%;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .member-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }

    .member-image {
        position: relative;
        width: 100%;
        padding-top: 100%;
        overflow: hidden;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
    }

    .member-image img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }

    .member-card:hover .member-image img {
        transform: scale(1.1);
    }

    .member-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        /* background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%); */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s ease;
    }

    .member-card:hover .member-overlay {
        opacity: 1;
    }

    .member-overlay i {
        font-size: 3rem;
        color: white;
    }

    .member-info {
        padding: 1.5rem;
        text-align: center;
    }

    .member-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .member-role {
        font-size: 0.95rem;
        /* color: #667eea; */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
    }

    .member-contact {
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .member-contact a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .member-contact a:hover {
        transform: scale(1.15);
        /* box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); */
    }

    /* MISSION BOX */
    .mission-box {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .mission-box::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-radius: 50%;
    }

    .mission-content {
        position: relative;
        z-index: 2;
    }

    .mission-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
    }

    .mission-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a365d;
        margin-bottom: 1.5rem;
    }

    .mission-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #4a5568;
        margin-bottom: 0;
    }

    /* ANIMATIONS */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Délais d'animation pour chaque carte */
    .member-card:nth-child(1) { animation-delay: 0.1s; }
    .member-card:nth-child(2) { animation-delay: 0.2s; }
    .member-card:nth-child(3) { animation-delay: 0.3s; }
    .member-card:nth-child(4) { animation-delay: 0.4s; }
    .member-card:nth-child(5) { animation-delay: 0.5s; }
    .member-card:nth-child(6) { animation-delay: 0.6s; }
    .member-card:nth-child(7) { animation-delay: 0.7s; }
    .member-card:nth-child(8) { animation-delay: 0.8s; }
    .member-card:nth-child(9) { animation-delay: 0.9s; }
    .member-card:nth-child(10) { animation-delay: 1s; }
    .member-card:nth-child(11) { animation-delay: 1.1s; }
    .member-card:nth-child(12) { animation-delay: 1.2s; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .page-hero-content h1 {
            font-size: 2.5rem;
        }

        .page-hero-content p {
            font-size: 1rem;
        }

        .section-title-main {
            font-size: 2rem;
        }

        .section-subtitle {
            font-size: 1rem;
        }

        .mission-box {
            padding: 2rem 1.5rem;
        }

        .mission-title {
            font-size: 1.5rem;
        }

        .mission-text {
            font-size: 1rem;
        }

        .mission-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }

        .member-name {
            font-size: 1rem;
        }

        .member-role {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .page-hero {
            height: 300px;
        }

        .page-hero-content h1 {
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .section-title-main {
            font-size: 1.5rem;
        }
    }

    /* ALERT STYLING */
    .alert-info {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border: none;
        border-radius: 15px;
        padding: 2rem;
        font-size: 1.1rem;
        color: #075985;
    }
</style>

<script>
    // Animation au scroll pour la mission box
    document.addEventListener('DOMContentLoaded', function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        const missionBox = document.querySelector('.mission-box');
        if (missionBox) {
            missionBox.style.opacity = '0';
            missionBox.style.transform = 'translateY(30px)';
            missionBox.style.transition = 'all 0.6s ease';
            observer.observe(missionBox);
        }
    });
</script>
@endsection