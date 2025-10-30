{{-- admin/membres/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestion des Membres')
@section('page-title', 'Gestion des Membres')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Liste des Membres ({{ $membres->total() }})</h5>
        <a href="{{ route('admin.membres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouveau Membre
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($membres as $membre)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        @if($membre->image)
                            <img src="{{ asset('storage/' . $membre->image) }}" class="card-img-top" alt="{{ $membre->nom_complet }}" style="height: 250px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                <div class="avatar" style="width: 80px; height: 80px; font-size: 2rem;">
                                    {{ strtoupper(substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1)) }}
                                </div>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $membre->nom_complet }}</h5>
                            @if($membre->description)
                                <p class="card-text text-muted small">{{ Str::limit($membre->description, 80) }}</p>
                            @endif
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-envelope me-1"></i>{{ $membre->email }}
                                </small>
                            </div>
                            @if($membre->telephone)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $membre->telephone }}
                                    </small>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group w-100">
                                <a href="{{ route('admin.membres.show', $membre) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.membres.edit', $membre) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.membres.destroy', $membre) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <p>Aucun membre trouvé</p>
                </div>
            @endforelse
        </div>
    </div>
    @if($membres->hasPages())
        <div class="card-footer">
            {{ $membres->links() }}
        </div>
    @endif
</div>
@endsection
@if('membres->hasPages()')
    <div class="card-footer">
        {{ $membres->links() }}
    </div> 
@endif