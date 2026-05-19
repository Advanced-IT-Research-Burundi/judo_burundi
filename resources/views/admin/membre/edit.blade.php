@extends('layouts.admin')

@section('title', 'Modifier un Membre')
@section('page-title', 'Modifier un Membre')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>{{ $membre->fullname }}</h5>
        <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.membres.update', $membre) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="fullname" class="form-control" value="{{ $membre->fullname }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $membre->email }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control" value="{{ $membre->telephone }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">{{ $membre->description }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nouvelle photo</label>
                            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                            <small class="text-muted">JPG, PNG, GIF ou WebP — max. 2 Mo. La photo est recadrée en carré à l’affichage (partie haute du visage privilégiée).</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="rounded-3 border bg-body-secondary p-3 h-100">
                        <p class="small fw-semibold text-primary mb-2">Aperçu actuel</p>
                        @if($url = $membre->imageUrl())
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
                <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
