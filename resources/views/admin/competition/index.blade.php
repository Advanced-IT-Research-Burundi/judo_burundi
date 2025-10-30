@extends('layouts.admin')

@section('title', 'Compétitions')
@section('page-title', 'Compétitions')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Liste des Compétitions ({{ $competitions->total() }})</h5>
        <a href="{{ route('admin.competitions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Compétition
        </a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Lieu</th>
                    <th>Date</th>
                    <th>Saison</th>
                    <th>Club Domicile</th>
                    <th>Club Adversaire</th>
                    <th>Résultat</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($competitions as $competition)
                    <tr>
                        <td>{{ $competition->nom }}</td>
                        <td>{{ $competition->lieu }}</td>
                        <td>{{ \Carbon\Carbon::parse($competition->date_competition)->format('d/m/Y') }}</td>
                        <td>{{ $competition->saison }}</td>
                        <td>{{ $competition->clubsdomicil->nom ?? '—' }}</td>
                        <td>{{ $competition->clubadversaire->nom ?? '—' }}</td>
                        <td>{{ $competition->resultat ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.competitions.show', $competition) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.competitions.edit', $competition) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.competitions.destroy', $competition) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette compétition ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-5">Aucune compétition trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($competitions->hasPages())
        <div class="card-footer">
            {{ $competitions->links() }}
        </div>
    @endif
</div>
@endsection
@if('competitions->hasPages()')
    <div class="card-footer">
        {{ $competitions->links() }}
    </div>
@endif