@extends('layouts.admin')

@section('title', 'Détails Province')
@section('page-title', 'Détails de la Province')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Province de {{ $province->nom }}</h5>
                    <div>
                        <a href="{{ route('admin.provinces.edit', $province) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date de création:</strong> {{ $province->created_at->format('d/m/Y à H:i') }}</p>
                        <p><strong>Dernière modification:</strong> {{ $province->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nombre de communes:</strong> <span class="badge bg-primary">{{ $province->communes->count() }}</span></p>
                        <p><strong>Nombre total de zones:</strong> 
                            <span class="badge bg-info">{{ $province->communes->sum(function($commune) { return $commune->zones->count(); }) }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des communes -->
        @if($province->communes->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Communes de cette province</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Commune</th>
                                <th>Zones</th>
                                <th>Quartiers</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($province->communes as $commune)
                                <tr>
                                    <td><strong>{{ $commune->nom }}</strong></td>
                                    <td>{{ $commune->zones->count() }} zones</td>
                                    <td>{{ $commune->zones->sum(function($zone) { return $zone->quartiers->count(); }) }} quartiers</td>
                                    <td>
                                        <a href="{{ route('admin.communes.show', $commune) }}" class="btn btn-sm btn-outline-primary">
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
                    <a href="{{ route('admin.communes.create') }}?province_id={{ $province->id }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus"></i> Ajouter une Commune
                    </a>
                    <a href="{{ route('admin.communes.index', ['province_id' => $province->id]) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list"></i> Voir toutes les communes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection