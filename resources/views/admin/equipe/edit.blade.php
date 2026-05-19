@extends('layouts.admin')

@section('title', 'Modifier un Membre de l’Équipe')
@section('page-title', 'Modifier un Membre de l’Équipe')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>{{ $equipe->fullname }}</h5>
        <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.equipes.update', $equipe) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="fullname" class="form-control" value="{{ $equipe->fullname }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Poste</label>
                            <input type="text" name="poste" class="form-control" value="{{ $equipe->poste }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nouvelle photo</label>
                            <input type="file" name="photo" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                            <small class="text-muted">JPG, PNG, GIF ou WebP — max. 2 Mo. La photo est recadrée en carré ou 4×3 à l’affichage (partie haute privilégiée).</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rounded-3 border bg-body-secondary p-3 h-100">
                        <p class="small fw-semibold text-primary mb-2">Aperçu actuel</p>
                        @if($url = $equipe->photoUrl())
                            <div class="text-center">
                                <img src="{{ $url }}"
                                     class="rounded-3 admin-membre-avatar-preview shadow-sm"
                                     alt="Photo actuelle"
                                     loading="lazy">
                            </div>
                        @else
                            <div class="text-center text-muted py-4 small">Aucune photo — les initiales s’affichent sur la liste.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap justify-content-end gap-2">
                <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
