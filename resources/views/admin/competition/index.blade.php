@extends('layouts.admin')

@section('title', 'Compétitions')
@section('page-title', 'Compétitions')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="row gy-2 gx-3 align-items-center">
            <div class="col-md-7">
                <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Compétitions ({{ $competitions->total() }})</h5>
            </div>
            <div class="col-md-5">
                <form method="GET" action="{{ route('admin.competitions.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Rechercher une compétition, un club ou une saison..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-light text-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted">
                Affichage de {{ $competitions->firstItem() ?? 0 }} à {{ $competitions->lastItem() ?? 0 }} sur {{ $competitions->total() }} compétitions
            </div>
            <a href="{{ route('admin.competitions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle Compétition
            </a>
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Compétition</th>
                    <th>Type / Saison</th>
                    <th>Date</th>
                    <th>Clubs</th>
                    <th class="text-center">Participants</th>
                    <th>Résultat</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($competitions as $competition)
                    <tr>
                        <td>
                            <strong>{{ $competition->nom }}</strong>
                            <div class="text-muted small mt-1">
                                {{ $competition->lieu ?? 'Lieu non défini' }}
                            </div>
                        </td>
                        <td>
                            @if($competition->type)
                                <span class="badge bg-secondary me-1">{{ $competition->type }}</span>
                            @endif
                            @if($competition->saison)
                                <span class="badge bg-info">{{ $competition->saison }}</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $competition->date_competition?->format('d/m/Y') ?? '—' }}</div>
                            <small class="text-muted">
                                @if($competition->date_competition && $competition->date_competition->isFuture())
                                    <span class="text-success">À venir</span>
                                @elseif($competition->date_competition)
                                    <span class="text-secondary">Passée</span>
                                @else
                                    <span class="text-warning">À définir</span>
                                @endif
                            </small>
                        </td>
                        <td>
                            <div>{{ $competition->clubDomicile->nom ?? '—' }}</div>
                            <div class="text-muted small">vs {{ $competition->clubAdversaire->nom ?? '—' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $competition->clubs->count() + 2 }}</span>
                        </td>
                        <td>
                            @if($competition->resultat)
                                <span>{{ \Illuminate\Support\Str::limit($competition->resultat, 50) }}</span>
                            @else
                                <span class="text-muted">Aucun résultat</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Actions compétition">
                                <a href="{{ route('admin.competitions.show', $competition) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.competitions.edit', $competition) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette compétition ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-frown fa-2x mb-3 d-block"></i>
                            Aucune compétition trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($competitions->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                Page {{ $competitions->currentPage() }} / {{ $competitions->lastPage() }}
            </div>
            <div>
                {{ $competitions->links() }}
            </div>
        </div>
    @endif
</div>
@endsection