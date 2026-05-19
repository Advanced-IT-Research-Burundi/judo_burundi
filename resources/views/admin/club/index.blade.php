@extends('layouts.admin')

@section('title', 'Gestion des Clubs')
@section('page-title', 'Gestion des Clubs')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-building me-2"></i>Clubs ({{ $clubs->total() }})</h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $clubs->firstItem() ?? 0 }} à {{ $clubs->lastItem() ?? 0 }} sur {{ $clubs->total() }} clubs
            </div>
            <a href="{{ route('admin.clubs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouveau club
            </a>
        </div>

        <div class="row g-3 admin-grid-card">
            @forelse($clubs as $club)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon green me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $club->nom }}</h5>
                                    <small class="text-muted">{{ $club->joueurs_count }} joueur(s)</small>
                                </div>
                            </div>

                            @if($club->description)
                                <p class="card-text text-muted small">
                                    {{ Str::limit($club->description, 100) }}
                                </p>
                            @endif

                            @if($club->capacite)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i>Capacité : {{ $club->capacite }}
                                    </small>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="btn-group btn-group-sm w-100 admin-table-actions" role="group" aria-label="Actions club">
                                <a href="{{ route('admin.clubs.show', $club) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.clubs.edit', $club) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.clubs.destroy', $club) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce club ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-4x mb-3"></i>
                        <p class="mb-3">Aucun club trouvé.</p>
                        <a href="{{ route('admin.clubs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Créer le premier club
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @if($clubs->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">
                Page {{ $clubs->currentPage() }} / {{ $clubs->lastPage() }}
            </div>
            <div>{{ $clubs->links() }}</div>
        </div>
    @endif
</div>
@endsection
