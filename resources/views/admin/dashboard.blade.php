@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistiques -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Joueurs
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_joueurs'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Posts
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_posts'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Catégories
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_categories'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Types de Posts
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['total_types_post'] }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Posts récents -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Posts Récents</h6>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-primary btn-sm">
                    Voir tous <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @forelse($stats['posts_recents'] as $post)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-muted">{{ $post->typePost->nom }} - {{ $post->date_post->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        <p class="text-muted mb-0">{{ Str::limit($post->contenu, 100) }}</p>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucun post trouvé.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Joueurs récents -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Joueurs Récents</h6>
                <a href="{{ route('admin.joueurs.index') }}" class="btn btn-primary btn-sm">
                    Voir tous <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @forelse($stats['joueurs_recents'] as $joueur)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $joueur->nom_complet }}</h6>
                                <small class="text-muted">{{ $joueur->categorie->nom }}</small><br>
                                <small class="text-muted">
                                    {{ $joueur->colline->nom }}, {{ $joueur->colline->zone->nom }}
                                </small>
                            </div>
                            <small class="text-muted">{{ $joueur->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucun joueur trouvé.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection