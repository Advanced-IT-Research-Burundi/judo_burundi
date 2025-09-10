@extends('layouts.admin')

@section('title', 'Ajouter une Province')
@section('page-title', 'Ajouter une Province')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Nouvelle Province</h5>
            <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.provinces.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la Province <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                       id="nom" name="nom" value="{{ old('nom') }}" required>
                @error('nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Ex: Gitega, Bujumbura, Ngozi, etc.</div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.provinces.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
