@extends('layouts.admin')

@section('title', 'Ajouter un Membre de l’Équipe')
@section('page-title', 'Ajouter un Membre de l’Équipe')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Nouveau membre (équipe fédérale)</h5>
        <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.equipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Poste</label>
                            <input type="text" name="poste" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                            <small class="text-muted">JPG, PNG, GIF ou WebP — max. 2 Mo.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap justify-content-end gap-2">
                <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
