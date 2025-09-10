@extends('layouts.admin')

@section('title', 'Provinces')
@section('page-title', 'Gestion des Provinces')

@section('page-actions')
<a href="{{ route('admin.provinces.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Ajouter une Province
</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Nombre de Communes</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($provinces as $province)
                        <tr>
                            <td>
                                <strong>{{ $province->nom }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $province->communes_count }} communes</span>
                            </td>
                            <td>{{ $province->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.provinces.show', $province) }}" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.provinces.edit', $province) }}" 
                                       class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($province->communes_count == 0)
                                        <form action="{{ route('admin.provinces.destroy', $province) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette province ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-danger" disabled title="Impossible de supprimer (contient des communes)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-map fa-3x mb-3 d-block"></i>
                                Aucune province trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Affichage de {{ $provinces->firstItem() ?? 0 }} à {{ $provinces->lastItem() ?? 0 }} 
                sur {{ $provinces->total() }} résultats
            </div>
            <div>
                {{ $provinces->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

