@extends('layouts.admin')

@section('title', 'Galerie')
@section('page-title', 'Gestion de la Galerie')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Liste des images</h4>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter une image
    </a>
</div>

<div class="row">
    @forelse($images as $gallery)
        <div  class="col-md-3 mb-4">
            <div  class="card shadow-sm">
                <img height="300" src="{{ $gallery->images ? asset('storage/'.$gallery->images) : asset('images/default.png') }}"
                     class="card-img-top" alt="{{ $gallery->titre }}">
                <div class="card-body">
                    <h6 class="card-title">{{ $gallery->titre }}</h6>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.gallery.show', $gallery) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Aucune image dans la galerie.</p>
    @endforelse
</div>

<div class="mt-3">
    {{ $images->links() }}
</div>
@endsection
