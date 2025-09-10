@extends('layouts.admin')

@section('title', 'Détails Commune')
@section('page-title', 'Détails de la Commune')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Commune de {{ $commune->nom }}</h5>
                    <div>
                        <a href="{{ route('admin.communes.edit', $commune) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('admin.communes.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Province:</strong> <span class="badge bg-primary">{{ $commune->province->nom }}</span></p>
                        <p><strong>Date de création:</strong> {{ $commune->created_at->format('d/m/Y à H:i') }}</p>
                        <p><strong>Dernière modification:</strong> {{ $commune->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre de zones:</strong> <span class="badge bg-info">{{ $commune->zones->count() }}</span></p>
                        <p><strong>Nombre total de quartiers:</strong> 
                            <span class="badge bg-secondary">{{ $commune->zones->sum(function($zone) { return $zone->quartiers->count(); }) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des zones -->
        @if($commune->zones->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Zones de cette commune</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Zone</th>
                                <th>Quartiers</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commune->zones as $zone)
                                <tr>
                                    <td><strong>{{ $zone->nom }}</strong></td>
                                    <td>{{ $zone->quartiers->count() }} quartiers</td>
                                    <td>
                                        <a href="{{ route('admin.zones.show', $zone) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Actions rapides</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.zones.create') }}?commune_id={{ $commune->id }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Ajouter une Zone
                    </a>
                    <a href="{{ route('admin.zones.index', ['commune_id' => $commune->id]) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i> Voir toutes les zones
                    </a>
                    <a href="{{ route('admin.provinces.show', $commune->province) }}" class="btn btn-outline-info">
                        <i class="fas fa-map"></i> Voir la province
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection