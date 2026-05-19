@extends('layouts.admin')

@section('title', 'Provinces')
@section('page-title', 'Gestion des Provinces')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-map me-2"></i>Provinces ({{ $provinces->total() }})</h5>
    </div>

    <div class="card-body table-responsive">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $provinces->firstItem() ?? 0 }} à {{ $provinces->lastItem() ?? 0 }} sur {{ $provinces->total() }} provinces
            </div>
            <a href="{{ route('admin.provinces.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Nouvelle province
            </a>
        </div>

        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Nombre de communes</th>
                    <th>Date de création</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($provinces as $province)
                    <tr>
                        <td><strong>{{ $province->nom }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $province->communes_count }} communes</span></td>
                        <td>{{ $province->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions province">
                                <a href="{{ route('admin.provinces.show', $province) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.provinces.edit', $province) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($province->communes_count == 0)
                                    <form action="{{ route('admin.provinces.destroy', $province) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette province ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-danger" disabled title="Impossible (communes liées)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <i class="fas fa-map fa-3x mb-3 d-block"></i>
                            Aucune province trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($provinces->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $provinces->currentPage() }} / {{ $provinces->lastPage() }}</div>
            <div>{{ $provinces->links() }}</div>
        </div>
    @endif
</div>
@endsection
