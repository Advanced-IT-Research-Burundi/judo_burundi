@extends('layouts.admin')

@section('title', 'Ajouter une Zone')
@section('page-title', 'Ajouter une Zone')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Nouvelle Zone</h5>
            <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.zones.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la Zone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="commune_id" class="form-label">Commune <span class="text-danger">*</span></label>
                        <select class="form-select @error('commune_id') is-invalid @enderror" 
                                id="commune_id" name="commune_id" required>
                            <option value="">Sélectionner une commune</option>
                            @foreach($communes as $commune)
                                <option value="{{ $commune->id }}" 
                                        {{ old('commune_id', request('commune_id')) == $commune->id ? 'selected' : '' }}>
                                    {{ $commune->nom }} ({{ $commune->province->nom }})
                                </option>
                            @endforeach
                        </select>
                        @error('commune_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
