@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Tableau de bord')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalJoueurs'] }}</h3>
                    <p>Total Joueurs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalClubs'] }}</h3>
                    <p>Clubs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalCompetitions'] }}</h3>
                    <p>Compétitions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalPosts'] }}</h3>
                    <p>Actualités</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row g-3">
        <!-- Recent Joueurs -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-users me-2"></i>Derniers Joueurs</h5>
                    <a href="{{ route('admin.joueurs.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @forelse($recentJoueurs as $joueur)
                        <div class="d-flex align-items-center mb-3 p-2 rounded hover-bg">
                            <div class="avatar me-3">
                                {{ strtoupper(substr($joueur->prenom, 0, 1) . substr($joueur->nom, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $joueur->nom_complet }}</h6>
                                <small class="text-muted">
                                    {{ $joueur->club->nom ?? 'N/A' }} • 
                                    {{ $joueur->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                            <a href="{{ route('admin.joueurs.show', $joueur) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucun joueur récent</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-newspaper me-2"></i>Dernières Actualités</h5>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @forelse($recentPosts as $post)
                        <div class="d-flex align-items-start mb-3 p-2 rounded hover-bg">
                            <div class="post-icon me-3">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ Str::limit($post->title, 40) }}</h6>
                                <small class="text-muted">
                                    {{ $post->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucune actualité récente</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Compétitions à venir -->
    @if($upcomingCompetitions->isNotEmpty())
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-calendar-alt me-2"></i>Compétitions à Venir</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($upcomingCompetitions as $competition)
                                <div class="col-md-4">
                                    <div class="event-card">
                                        <div class="event-date">
                                            <div class="day">{{ $competition->date_competition->format('d') }}</div>
                                            <div class="month">{{ $competition->date_competition->format('M') }}</div>
                                        </div>
                                        <div class="event-info flex-grow-1">
                                            <h6 class="mb-1">{{ $competition->nom }}</h6>
                                            <p class="text-muted small mb-1">{{ $competition->lieu }}</p>
                                            <small class="text-primary">{{ $competition->type }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection