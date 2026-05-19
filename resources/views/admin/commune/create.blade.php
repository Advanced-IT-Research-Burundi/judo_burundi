@extends('layouts.admin')

@section('title', 'Ajouter une Commune')
@section('page-title', 'Ajouter une Commune')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-city me-2"></i>Nouvelle commune</h5>
        <a href="{{ route('admin.communes.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.communes.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la Commune <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom') }}" required>
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
                                        {{ old('province_id', request('province_id')) == $province->id ? 'selected' : '' }}>
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
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection