@extends('layouts.admin')

@section('title', 'Notre Équipe')
@section('page-title', 'Notre Équipe')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-user-friends me-2"></i>Équipe ({{ $equipes->total() }})</h5>
        <a href="{{ route('admin.equipes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un Membre
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($equipes as $equipe)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 text-center shadow-sm">
                        @if($equipe->photo)
                            <img src="{{ asset('storage/' . $equipe->photo) }}" class="card-img-top rounded-circle mx-auto mt-3" alt="{{ $equipe->fullname }}" style="width:120px; height:120px; object-fit:cover;">
                        @else
                            <i class="fas fa-user-circle fa-5x text-muted my-3"></i>
                        @endif
                        <div class="card-body">
                            <h6 class="card-title mb-0">{{ $equipe->fullname }}</h6>
                            <small class="text-muted">{{ $equipe->poste }}</small>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group">
                                <a href="{{ route('admin.equipes.show', $equipe) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.equipes.edit', $equipe) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.equipes.destroy', $equipe) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce membre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <p>Aucun membre d’équipe trouvé.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
@if($equipes->hasPages())
    <div class="card-footer">
        {{ $equipes->links() }}
    </div> 
@endif