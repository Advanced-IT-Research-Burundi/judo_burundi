@extends('layouts.admin')

@section('title', 'Notre Équipe')
@section('page-title', 'Notre Équipe')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-user-friends me-2"></i>Équipe ({{ $equipes->total() }})</h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $equipes->firstItem() ?? 0 }} à {{ $equipes->lastItem() ?? 0 }} sur {{ $equipes->total() }} membres
            </div>
            <a href="{{ route('admin.equipes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajouter un membre
            </a>
        </div>

        <div class="row g-3 admin-grid-card">
            @forelse($equipes as $equipe)
                @php
                    $photoUrl = $equipe->photoUrl();
                    $initials = collect(preg_split('/\s+/', trim((string) ($equipe->fullname ?? '')), -1, PREG_SPLIT_NO_EMPTY))
                        ->take(2)
                        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                        ->implode('');
                    if ($initials === '') {
                        $initials = '—';
                    }
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm overflow-hidden">
                        <div class="admin-membre-thumb border-bottom">
                            @if($photoUrl)
                                <div class="ratio ratio-4x3">
                                    <img src="{{ $photoUrl }}"
                                         class="rounded-top"
                                         alt="Photo — {{ $equipe->fullname }}"
                                         loading="lazy"
                                         decoding="async">
                                </div>
                            @else
                                <div class="ratio ratio-4x3 d-flex align-items-center justify-content-center bg-body-secondary">
                                    <div class="avatar text-uppercase" style="width: 72px; height: 72px; font-size: 1.35rem;">
                                        {{ $initials }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $equipe->fullname }}</h5>
                            @if($equipe->poste)
                                <p class="card-text text-muted small mb-0">{{ $equipe->poste }}</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="btn-group btn-group-sm w-100 admin-table-actions" role="group" aria-label="Actions membre équipe">
                                <a href="{{ route('admin.equipes.show', $equipe) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.equipes.edit', $equipe) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.equipes.destroy', $equipe) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce membre ?')">
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
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <p>Aucun membre d’équipe trouvé.</p>
                </div>
            @endforelse
        </div>
    </div>
    @if($equipes->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $equipes->currentPage() }} / {{ $equipes->lastPage() }}</div>
            <div>{{ $equipes->links() }}</div>
        </div>
    @endif
</div>
@endsection
