@extends('layouts.admin')

@section('title', 'Ajouter un Membre')
@section('page-title', 'Ajouter un Membre')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-id-badge me-2"></i>Ajouter un membre</h5>
        <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.membres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <!-- Nom complet -->
                <div class="col-md-6">
                    <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                    <input type="text"
                           name="fullname"
                           value="{{ old('fullname') }}"
                           class="form-control @error('fullname') is-invalid @enderror"
                           required>
                    @error('fullname')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text"
                           name="telephone"
                           value="{{ old('telephone') }}"
                           class="form-control @error('telephone') is-invalid @enderror">
                    @error('telephone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              rows="3"
                              class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Photo -->
                <div class="col-12">
                    <label class="form-label">Photo</label>
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/jpeg,image/png,image/gif,image/webp">
                    <small class="text-muted">JPG, PNG, GIF ou WebP — max. 2 Mo.</small>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
