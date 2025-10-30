@extends('layouts.admin')

@section('title', 'Galerie d’images')
@section('page-title', 'Galerie d’images')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-images me-2"></i>Galerie ({{ $images->total() }})</h5>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Image
        </a>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @forelse($images as $image)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $image->images) }}" alt="{{ $image->titre }}" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h6 class="card-title">{{ $image->titre }}</h6>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <div class="btn-group">
                                <a href="{{ route('admin.gallery.show', $image) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.gallery.edit', $image) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.gallery.destroy', $image) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette image ?')">
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
                    <p>Aucune image trouvée.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
@if($images->hasPages())
    <div class="card-footer">
        {{ $images->links() }}
    </div>
@endif