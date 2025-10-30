@extends('layouts.admin')

@section('title', 'Modifier un Membre')
@section('page-title', 'Modifier un Membre')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.membres.update', $membre) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                <div class="col-md-6">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    @if($membre->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $membre->image) }}" width="100" class="rounded">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Retour</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
