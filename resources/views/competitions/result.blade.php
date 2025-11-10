@extends('layouts.user')

@section('title', 'Résultat de la compétition')

@section('content')
<div class="container-fluid mt-4 px-4">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('competitions.index') }}">
                    <i class="fas fa-home me-1"></i>Compétitions
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Résultats</li>
        </ol>
    </nav>

    <!-- HEADER DE LA COMPÉTITION -->
    <div class="competition-header-card card shadow-lg border-0 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- ICONE PRINCIPALE -->
                <div class="col-md-2 text-center">
                    <div class="main-trophy-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                </div>

                <!-- INFORMATIONS PRINCIPALES -->
                <div class="col-md-7">
                    <h1 class="competition-title mb-3">{{ $competition->nom }}</h1>
                    
                    <div class="competition-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            <span class="meta-label">Date</span>
                            <span class="meta-value">{{ \Carbon\Carbon::parse($competition->date_competition)->translatedFormat('d F Y') }}</span>
                        </div>
                        
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span class="meta-label">Lieu</span>
                            <span class="meta-value">{{ $competition->lieu ?? 'Non spécifié' }}</span>
                        </div>

                        @if($competition->type)
                        <div class="meta-item">
                            <i class="fas fa-tag text-info"></i>
                            <span class="meta-label">Catégorie</span>
                            <span class="meta-value">{{ $competition->type }}</span>
                        </div>
                        @endif

                        @if($competition->saison)
                        <div class="meta-item">
                            <i class="fas fa-calendar-week text-success"></i>
                            <span class="meta-label">Saison</span>
                            <span class="meta-value">{{ $competition->saison }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="col-md-3 text-end">
                    <button onclick="window.print()" class="btn btn-outline-light w-100">
                        <i class="fas fa-print me-2"></i>Imprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- CLUBS PARTICIPANTS -->
    @if($competition->clubdomicile || $competition->clubadversaire)
    <div class="row mb-4">
        <!-- CLUB DOMICILE -->
        @if($competition->clubdomicile)
        <div class="col-md-6 mb-3">
            <div class="club-card card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="club-header">
                        <div class="club-icon home-club">
                            <i class="fas fa-home"></i>
                        </div>
                        <div>
                            <h5 class="club-label mb-1">CLUB DOMICILE</h5>
                            <h3 class="club-name">{{ $competition->clubdomicile->nom }}</h3>
                        </div>
                    </div>
                    @if($competition->clubdomicile->ville)
                    <p class="club-location mt-3">
                        <i class="fas fa-map-pin me-2"></i>{{ $competition->clubdomicile->ville }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- CLUB ADVERSAIRE -->
        @if($competition->clubadversaire)
        <div class="col-md-6 mb-3">
            <div class="club-card card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="club-header">
                        <div class="club-icon away-club">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h5 class="club-label mb-1">CLUB ADVERSAIRE</h5>
                            <h3 class="club-name">{{ $competition->clubadversaire->nom }}</h3>
                        </div>
                    </div>
                    @if($competition->clubadversaire->ville)
                    <p class="club-location mt-3">
                        <i class="fas fa-map-pin me-2"></i>{{ $competition->clubadversaire->ville }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- RÉSULTATS -->
    <div class="row">
        <div class="col-12">
            <div class="results-card card border-0 shadow-lg">
                <div class="card-header results-header">
                    <h3 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Résultats de la compétition
                    </h3>
                </div>
                <div class="card-body p-4">
                    @if($competition->resultat)
                        <div class="result-content">
                            <!-- SI LE RÉSULTAT EST UN SCORE (format: X-Y) -->
                            @if(preg_match('/^(\d+)\s*-\s*(\d+)$/', $competition->resultat, $matches))
                                <div class="score-display">
                                    <div class="score-box">
                                        <div class="score-team">{{ $competition->clubdomicile->nom ?? 'Domicile' }}</div>
                                        <div class="score-value winner">{{ $matches[1] }}</div>
                                    </div>
                                    <div class="score-separator">VS</div>
                                    <div class="score-box">
                                        <div class="score-team">{{ $competition->clubadversaire->nom ?? 'Adversaire' }}</div>
                                        <div class="score-value {{ $matches[2] > $matches[1] ? 'winner' : '' }}">{{ $matches[2] }}</div>
                                    </div>
                                </div>

                                <!-- GAGNANT -->
                                <div class="winner-announcement">
                                    <i class="fas fa-crown me-2"></i>
                                    <span class="winner-text">
                                        Victoire de 
                                        <strong>
                                            {{ $matches[1] > $matches[2] ? 
                                               ($competition->clubdomicile->nom ?? 'Domicile') : 
                                               ($competition->clubadversaire->nom ?? 'Adversaire') }}
                                        </strong>
                                    </span>
                                </div>
                            @else
                                <!-- RÉSULTAT TEXTUEL -->
                                <div class="result-text">
                                    <div class="result-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="result-description">
                                        {!! nl2br(e($competition->resultat)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- PAS DE RÉSULTAT -->
                        <div class="no-result">
                            <i class="fas fa-hourglass-half fa-3x mb-3"></i>
                            <h4>Résultats à venir</h4>
                            <p class="text-muted">Les résultats de cette compétition ne sont pas encore disponibles.</p>
                            <button onclick="location.reload()" class="btn btn-primary mt-3">
                                <i class="fas fa-sync-alt me-2"></i>Actualiser
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- DESCRIPTION -->
    @if($competition->description)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informations complémentaires
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $competition->description }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- STATISTIQUES (Si disponibles) -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="stat-card card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stat-value mt-3">2</h3>
                    <p class="stat-label mb-0">Clubs participants</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-success">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3 class="stat-value mt-3">{{ $competition->type ?? '—' }}</h3>
                    <p class="stat-label mb-0">Catégorie</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="stat-card card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="stat-value mt-3">{{ \Carbon\Carbon::parse($competition->date_competition)->format('d/m/Y') }}</h3>
                    <p class="stat-label mb-0">Date</p>
                </div>
            </div>
        </div>
    </div>

    <!-- BOUTONS D'ACTION -->
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center">
            <a href="{{ route('competitions.index') }}" class="btn btn-lg btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i>Retour aux compétitions
            </a>
            <button onclick="shareResult()" class="btn btn-lg btn-outline-primary">
                <i class="fas fa-share-alt me-2"></i>Partager
            </button>
        </div>
    </div>

</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* STYLES SPÉCIFIQUES À LA PAGE RÉSULTATS */

    /* BREADCRUMB */
    .breadcrumb {
        background-color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #764ba2;
    }

    /* HEADER CARD */
    .competition-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }

    .competition-header-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .main-trophy-icon {
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .competition-title {
        font-size: 2rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .competition-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.2);
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .meta-item i {
        font-size: 1.2rem;
    }

    .meta-label {
        font-size: 0.8rem;
        opacity: 0.9;
        margin-right: 0.25rem;
    }

    .meta-value {
        font-weight: 600;
    }

    /* CLUB CARDS */
    .club-card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .club-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .club-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .club-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        flex-shrink: 0;
    }

    .home-club {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .away-club {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .club-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .club-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .club-location {
        color: #718096;
        margin: 0;
    }

    /* RESULTS CARD */
    .results-card {
        border-radius: 20px;
        overflow: hidden;
    }

    .results-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem 2rem;
        border: none;
    }

    .results-header h3 {
        font-weight: 700;
    }

    /* SCORE DISPLAY */
    .score-display {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 3rem;
        padding: 3rem 0;
    }

    .score-box {
        text-align: center;
        flex: 1;
        max-width: 300px;
    }

    .score-team {
        font-size: 1.2rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 1rem;
    }

    .score-value {
        font-size: 5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .score-value.winner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: winnerPulse 1.5s ease-in-out infinite;
    }

    @keyframes winnerPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .score-separator {
        font-size: 2rem;
        font-weight: 700;
        color: #cbd5e0;
    }

    .winner-announcement {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 15px;
        margin-top: 2rem;
    }

    .winner-announcement i {
        color: #f59e0b;
        font-size: 2rem;
        vertical-align: middle;
    }

    .winner-text {
        font-size: 1.5rem;
        color: #78350f;
    }

    /* RESULT TEXT */
    .result-text {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        padding: 2rem;
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-radius: 15px;
    }

    .result-icon {
        width: 80px;
        height: 80px;
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .result-description {
        font-size: 1.2rem;
        line-height: 1.8;
        color: #1e40af;
    }

    /* NO RESULT */
    .no-result {
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-result i {
        color: #cbd5e0;
        animation: rotate 2s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .no-result h4 {
        color: #4a5568;
        font-weight: 700;
        margin-top: 1rem;
    }

    /* STAT CARDS */
    .stat-card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
        font-size: 2rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }

    .stat-label {
        color: #718096;
        font-size: 1rem;
    }

    /* BUTTONS */
    .btn-lg {
        padding: 0.875rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .btn-outline-light {
        color: white;
        border-color: rgba(255,255,255,0.5);
    }

    .btn-outline-light:hover {
        background-color: rgba(255,255,255,0.2);
        border-color: white;
        color: white;
    }

    /* PRINT STYLES */
    @media print {
        .breadcrumb,
        .btn,
        .stat-card {
            display: none !important;
        }

        .competition-header-card {
            background: white !important;
            color: black !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .competition-title {
            font-size: 1.5rem;
        }

        .competition-meta {
            flex-direction: column;
            gap: 0.75rem;
        }

        .score-display {
            flex-direction: column;
            gap: 1.5rem;
        }

        .score-value {
            font-size: 3rem;
        }

        .winner-text {
            font-size: 1.2rem;
        }

        .main-trophy-icon {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .club-icon {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .club-name {
            font-size: 1.2rem;
        }
    }
</style>

<script>
    function shareResult() {
        const title = '{{ $competition->nom }}';
        const text = 'Résultats de la compétition: {{ $competition->nom }}';
        const url = window.location.href;

        if (navigator.share) {
            navigator.share({
                title: title,
                text: text,
                url: url
            }).catch(err => console.log('Erreur de partage:', err));
        } else {
            // Fallback: copier le lien
            navigator.clipboard.writeText(url).then(() => {
                alert('Lien copié dans le presse-papiers!');
            });
        }
    }

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endsection