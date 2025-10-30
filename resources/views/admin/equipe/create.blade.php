@extends('layouts.admin')
@section('title', 'Ajouter un Membre de l’Équipe')
@section('page-title', 'Ajouter un Membre de l’Équipe')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.equipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="fullname" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Poste</label>
                    <input type="text" name="poste" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
