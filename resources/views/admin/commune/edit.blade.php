@extends('layouts.admin')

@section('title', 'Modifier Commune')
@section('page-title', 'Modifier Commune')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Modifier "{{ $commune->nom }}"</h5>
            <a href="{{ route('admin.communes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.communes.update', $commune) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la Commune <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $commune->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="province_id" class="form-label">Province <span class="text-danger">*</span></label>
                        <select class="form-select @error('province_id') is-invalid @enderror" 
                                id="province_id" name="province_id" required>
                            <option value="">Sélectionner une province</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->id }}" 
                                        {{ old('province_id', $commune->province_id) == $province->id ? 'selected' : '' }}>
                                    {{ $province->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.communes.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
