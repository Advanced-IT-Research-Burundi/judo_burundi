@extends('layouts.admin')

@section('title', 'Communes')
@section('page-title', 'Gestion des Communes')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="row gy-2 gx-3 align-items-center">
            <div class="col-lg-4">
                <h5 class="mb-0"><i class="fas fa-city me-2"></i>Communes ({{ $communes->total() }})</h5>
            </div>
            <div class="col-lg-8">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.communes.index') }}" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="Rechercher une commune..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light text-primary btn-sm flex-shrink-0" title="Rechercher">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.communes.index') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="province_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Toutes les provinces</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body table-responsive">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $communes->firstItem() ?? 0 }} à {{ $communes->lastItem() ?? 0 }} sur {{ $communes->total() }} communes
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                @if(request()->hasAny(['search', 'province_id']))
                    <a href="{{ route('admin.communes.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i>Réinitialiser les filtres
                    </a>
                @endif
                <a href="{{ route('admin.communes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Nouvelle commune
                </a>
            </div>
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Commune</th>
                    <th>Province</th>
                    <th>Nombre de zones</th>
                    <th>Date de création</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($communes as $commune)
                    <tr>
                        <td><strong>{{ $commune->nom }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $commune->province->nom }}</span></td>
                        <td><span class="badge bg-info text-dark">{{ $commune->zones_count }} zones</span></td>
                        <td>{{ $commune->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions commune">
                                <a href="{{ route('admin.communes.show', $commune) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.communes.edit', $commune) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($commune->zones_count == 0)
                                    <form action="{{ route('admin.communes.destroy', $commune) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commune ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-danger" disabled title="Impossible (zones liées)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="fas fa-building fa-3x mb-3 d-block"></i>
                            Aucune commune trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($communes->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $communes->currentPage() }} / {{ $communes->lastPage() }}</div>
            <div>{{ $communes->appends(request()->query())->links() }}</div>
        </div>
    @endif
</div>
@endsection
