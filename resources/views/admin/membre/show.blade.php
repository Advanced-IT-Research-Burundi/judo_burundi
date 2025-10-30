@extends('layouts.admin')

@section('title', $membre->fullname)
@section('page-title', 'Détails du Membre')

@section('content')
<div class="card shadow-sm">
    <div class="card-body text-center">
        @if($membre->image)
            <img src="{{ asset('storage/' . $membre->image) }}" class="rounded-circle mb-3" style="width:150px;height:150px;object-fit:cover;">
        @else
            <i class="fas fa-user-circle fa-7x text-muted mb-3"></i>
        @endif

        <h4>{{ $membre->fullname }}</h4>
        <p class="text-muted mb-2">{{ $membre->description }}</p>
        <p><i class="fas fa-envelope me-2"></i>{{ $membre->email }}</p>
        <p><i class="fas fa-phone me-2"></i>{{ $membre->telephone }}</p>

        <div class="mt-3">
            <a href="{{ route('admin.membres.index') }}" class="btn btn-secondary">Retour</a>
            <a href="{{ route('admin.membres.edit', $membre) }}" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Modifier</a>
        </div>
    </div>
</div>
@endsection
