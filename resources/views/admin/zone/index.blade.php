@extends('layouts.admin')

@section('title', 'Zones')
@section('page-title', 'Gestion des Zones')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="row gy-2 gx-3 align-items-center">
            <div class="col-lg-4">
                <h5 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Zones ({{ $zones->total() }})</h5>
            </div>
            <div class="col-lg-8">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.zones.index') }}" class="d-flex gap-2">
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="Rechercher une zone..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-light text-primary btn-sm flex-shrink-0" title="Rechercher">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.zones.index') }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <select name="commune_id" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Toutes les communes</option>
                                @foreach($communes as $commune)
                                    <option value="{{ $commune->id }}" {{ request('commune_id') == $commune->id ? 'selected' : '' }}>
                                        {{ $commune->nom }} ({{ $commune->province->nom }})
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
                Affichage de {{ $zones->firstItem() ?? 0 }} à {{ $zones->lastItem() ?? 0 }} sur {{ $zones->total() }} zones
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                @if(request()->hasAny(['search', 'commune_id']))
                    <a href="{{ route('admin.zones.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i>Réinitialiser les filtres
                    </a>
                @endif
                <a href="{{ route('admin.zones.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>Nouvelle zone
                </a>
            </div>
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Zone</th>
                    <th>Commune</th>
                    <th>Province</th>
                    <th>Quartiers</th>
                    <th>Date création</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($zones as $zone)
                    <tr>
                        <td><strong>{{ $zone->nom }}</strong></td>
                        <td>{{ $zone->commune->nom }}</td>
                        <td><span class="badge bg-secondary">{{ $zone->commune->province->nom }}</span></td>
                        <td><span class="badge bg-info text-dark">{{ $zone->quartiers_count }} quartiers</span></td>
                        <td>{{ $zone->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions zone">
                                <a href="{{ route('admin.zones.show', $zone) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($zone->quartiers_count == 0)
                                    <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-danger" disabled title="Impossible (quartiers liés)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-map-marker-alt fa-3x mb-3 d-block"></i>
                            Aucune zone trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($zones->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $zones->currentPage() }} / {{ $zones->lastPage() }}</div>
            <div>{{ $zones->appends(request()->query())->links() }}</div>
        </div>
    @endif
</div>
@endsection
