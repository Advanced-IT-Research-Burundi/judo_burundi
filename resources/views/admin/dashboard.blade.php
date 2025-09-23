@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

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
                    <p>Total Membres</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalCategories'] }}</h3>
                    <p>Catégories</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalPosts'] }}</h3>
                    <p>Articles Publiés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['totalCompetitions'] }}</h3>
                    <p>Compétitions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="row">
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
                                    {{ $joueur->categorie->nom ?? 'N/A' }} • 
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
                    <h5><i class="fas fa-newspaper me-2"></i>Derniers Articles</h5>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    @forelse($recentPosts as $post)
                        <div class="d-flex align-items-start mb-3 p-2 rounded hover-bg">
                            <div class="post-icon me-3">
                                <i class="fas fa-{{ $post->typePost->nom === 'Compétition' ? 'trophy' : ($post->typePost->nom === 'Formation' ? 'graduation-cap' : 'newspaper') }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ Str::limit($post->titre, 40) }}</h6>
                                <small class="text-muted">
                                    {{ $post->typePost->nom }} • 
                                    {{ $post->date_post->format('d/m/Y') }}
                                </small>
                            </div>
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aucun article récent</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Événements à venir -->
    @if($stats['evenementsAVenir']->isNotEmpty())
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-calendar-alt me-2"></i>Événements à Venir</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($stats['evenementsAVenir'] as $evenement)
                                <div class="col-md-4">
                                    <div class="event-card">
                                        <div class="event-date">
                                            <div class="day">{{ $evenement->date_evenement_debut->format('d') }}</div>
                                            <div class="month">{{ $evenement->date_evenement_debut->format('M') }}</div>
                                        </div>
                                        <div class="event-info">
                                            <h6>{{ $evenement->titre }}</h6>
                                            <p class="text-muted small">{{ $evenement->lieu_evenement }}</p>
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

@push('styles')
<style>
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.3s;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stat-icon.green { background: linear-gradient(135deg, #7CB342 0%, #689F3A 100%); }
    .stat-icon.orange { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stat-icon.purple { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

    .stat-info h3 {
        font-size: 2rem;
        color: #1a365d;
        margin-bottom: 0.2rem;
        margin: 0;
    }

    .stat-info p {
        color: #666;
        font-weight: 500;
        margin: 0;
    }

    .avatar {
        width: 40px;
        height: 40px;
        background: #7CB342;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .post-icon {
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #7CB342;
    }

    .hover-bg:hover {
        background-color: #f8f9fa;
    }

    .event-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .event-date {
        text-align: center;
        background: #7CB342;
        color: white;
        padding: 0.5rem;
        border-radius: 8px;
        min-width: 60px;
    }

    .event-date .day {
        font-size: 1.5rem;
        font-weight: bold;
        line-height: 1;
    }

    .event-date .month {
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .event-info h6 {
        margin-bottom: 0.25rem;
    }
</style>
@endpush