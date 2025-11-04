@extends('layouts.user')

@section('title', 'Nos Compétitions - Fédération Burundaise de Judo')

@section('content')
    <style>
        .competitions-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }

        @media screen and (max-width: 1200px) {
            .competitions-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media screen and (max-width: 768px) {
            .competitions-container {
                grid-template-columns: 1fr;
            }
        }

        /* Make the whole card clickable by wrapping in an anchor */
        .competition-link {
            display: block;
            text-decoration: none;
            color: inherit;
            border-radius: 12px;
        }

        .competition-card {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            border: 1px solid #eef2f7;
            position: relative;
        }

        .competition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .competition-header {
            background: linear-gradient(135deg, #3498db, #2d4a7c);
            padding: 20px;
            position: relative;
        }

        .competition-status {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            backdrop-filter: blur(5px);
        }

        .competition-title {
            color: white;
            font-size: 1.3em;
            font-weight: 600;
            margin: 0 0 10px 0;
            padding-right: 80px;
        }

        .competition-teams {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .competition-team {
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 12px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }

        .competition-vs {
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
        }

        .competition-details {
            padding: 10px;
        }

        .competition-info {
            margin-bottom: 10px;
        }

        .competition-info div {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
            color: #4a5568;
        }

        .competition-info i {
            width: 24px;
            height: 24px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ebf4ff;
            color: #3498db;
            border-radius: 6px;
        }

        .competition-description {
            color: #718096;
            margin-bottom: 10px;
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <?php
      $todayDate = new DateTime();
    ?>
    <!-- Page Hero Section -->
    <section class="page-hero competitions" style="background-image: url('{{ asset('images/judo3.jpg') }}');">
        <div class="page-hero-content">
            <h1>Nos Compétitions</h1>
            <p>Retrouvez toutes les informations sur les compétitions à venir et passées.</p>
            
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Accueil</a>
                <span>›</span>
                <span>Compétitions</span>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section style="padding: 20px 0;">
        <div class="container">
            <div>
                {{-- <h2 style="text-align: center; margin-bottom: 40px;">Prochaines Compétitions</h2>
                <p style="font-size: 18px; line-height: 1.6; text-align: center;">
                    Restez à jour avec notre calendrier des compétitions à venir. Que vous soyez un athlète cherchant à participer ou un fan souhaitant assister, nous avons toutes les informations dont vous avez besoin.
                </p> --}}
                <div class="competitions-container">
                    @foreach ($competitions as $competition)
                    <a href="#" class="competition-link" aria-label="Voir la compétition {{ $competition->nom }}">
                    {{-- <a href="{{ route('competitions.show', $competition->id) }}" class="competition-link" aria-label="Voir la compétition {{ $competition->nom }}"> --}}
                        <div class="competition-card">
                            <div class="competition-header">
                                @if ($todayDate > (new DateTime($competition->date_competition)))
                                <span class="competition-status"  style="background: #ca5d42">Passée</span>
                                @else
                                <span class="competition-status"  style="background: #50a158">À venir</span>
                                @endif
                                <h3 class="competition-title">{{ $competition->nom }}</h3>
                                <div class="competition-teams">
                                    <span class="competition-team">{{ $competition->clubdomicile->nom ?? 'Equipe Inconnue' }}</span>
                                    <span class="competition-vs">VS</span>
                                    <span class="competition-team">{{ $competition->clubadversaire->nom ?? 'Equipe Inconnue' }}</span>
                                </div>
                            </div>
                            <div class="competition-details">
                                <div class="competition-info">
                                    <div>
                                        <i class="far fa-calendar"></i>
                                        <span>{{ date('d F Y', strtotime($competition->date_competition)) }}</span>
                                    </div>
                                    <div>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $competition->lieu }}</span>
                                    </div>
                                </div>
                                <p class="competition-description">
                                    {{ $competition->description }}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
@endsection