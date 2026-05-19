@extends('layouts.admin')

@section('title', 'Galerie d’images')
@section('page-title', 'Galerie d’images')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galerie ({{ $images->total() }})</h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $images->firstItem() ?? 0 }} à {{ $images->lastItem() ?? 0 }} sur {{ $images->total() }} images
            </div>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle image
            </a>
        </div>

        <div class="row g-3 admin-grid-card">
            @forelse($images as $image)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm overflow-hidden">
                        <img src="{{ asset('storage/' . $image->images) }}" alt="{{ $image->titre }}" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h6 class="card-title mb-0">{{ $image->titre }}</h6>
                        </div>
                        <div class="card-footer bg-white border-top text-center">
                            <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions image">
                                <a href="{{ route('admin.gallery.show', $image) }}" class="btn btn-outline-info" title="Voir"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-outline-warning" title="Modifier"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette image ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <p>Aucune image trouvée.</p>
                </div>
            @endforelse
        </div>
    </div>
    @if($images->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $images->currentPage() }} / {{ $images->lastPage() }}</div>
            <div>{{ $images->links() }}</div>
        </div>
    @endif
</div>
@endsection
