@extends('layouts.admin')

@section('title', 'Ajouter un Membre')
@section('page-title', 'Ajouter un Membre')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.membres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="fullname" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-control">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
