@extends('layouts.admin')

@section('title', 'Communes')
@section('page-title', 'Gestion des Communes')

@section('page-actions')
<a href="{{ route('admin.communes.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Ajouter une Commune
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.communes.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Rechercher une commune..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.communes.index') }}">
                    <div class="d-flex">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <select name="province_id" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Toutes les provinces</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" 
                                        {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                    {{ $province->nom }}
                                </option>
                            @endforeach
                        </select>
                        @if(request()->hasAny(['search', 'province_id']))
                            <a href="{{ route('admin.communes.index') }}" class="btn btn-outline-secondary">
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
                        <th>Commune</th>
                        <th>Province</th>
                        <th>Nombre de Zones</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($communes as $commune)
                        <tr>
                            <td>
                                <strong>{{ $commune->nom }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $commune->province->nom }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $commune->zones_count }} zones</span>
                            </td>
                            <td>{{ $commune->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.communes.show', $commune) }}" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.communes.edit', $commune) }}" 
                                       class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($commune->zones_count == 0)
                                        <form action="{{ route('admin.communes.destroy', $commune) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commune ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-danger" disabled title="Impossible de supprimer (contient des zones)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-building fa-3x mb-3 d-block"></i>
                                Aucune commune trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Affichage de {{ $communes->firstItem() ?? 0 }} à {{ $communes->lastItem() ?? 0 }} 
                sur {{ $communes->total() }} résultats
            </div>
            <div>
                {{ $communes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
