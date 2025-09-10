@extends('layouts.admin')

@section('title', 'Zones')
@section('page-title', 'Gestion des Zones')

@section('page-actions')
<a href="{{ route('admin.zones.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Ajouter une Zone
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.zones.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Rechercher une zone..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.zones.index') }}">
                    <div class="d-flex">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="commune_id" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Toutes les communes</option>
                            @foreach($communes as $commune)
                                <option value="{{ $commune->id }}" 
                                        {{ request('commune_id') == $commune->id ? 'selected' : '' }}>
                                    {{ $commune->nom }} ({{ $commune->province->nom }})
                                </option>
                            @endforeach
                        </select>
                        @if(request()->hasAny(['search', 'commune_id']))
                            <a href="{{ route('admin.zones.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Zone</th>
                        <th>Commune</th>
                        <th>Province</th>
                        <th>Quartiers</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zones as $zone)
                        <tr>
                            <td><strong>{{ $zone->nom }}</strong></td>
                            <td>{{ $zone->commune->nom }}</td>
                            <td><span class="badge bg-primary">{{ $zone->commune->province->nom }}</span></td>
                            <td><span class="badge bg-secondary">{{ $zone->quartiers_count }} quartiers</span></td>
                            <td>{{ $zone->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.zones.show', $zone) }}" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.zones.edit', $zone) }}" 
                                       class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($zone->quartiers_count == 0)
                                        <form action="{{ route('admin.zones.destroy', $zone) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-danger" disabled title="Impossible de supprimer (contient des quartiers)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-map-marker-alt fa-3x mb-3 d-block"></i>
                                Aucune zone trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Affichage de {{ $zones->firstItem() ?? 0 }} à {{ $zones->lastItem() ?? 0 }} 
                sur {{ $zones->total() }} résultats
            </div>
            <div>
                {{ $zones->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
