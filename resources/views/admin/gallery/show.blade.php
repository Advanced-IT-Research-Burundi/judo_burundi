@extends('layouts.admin')

@section('title', 'Détail Image')
@section('page-title', 'Détails de l\'Image')

@section('content')
<div class="card">
    <div class="card-body text-center">
        <h4>{{ $gallery->titre }}</h4>
        <img src="{{ $gallery->images ? asset('storage/'.$gallery->images) : asset('images/default.png') }}"
             alt="{{ $gallery->titre }}" class="img-fluid rounded shadow mt-3 mb-4" style="max-width:600px;">
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Supprimer cette image ?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger"><i class="fas fa-trash"></i> Supprimer</button>
            </form>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>
@endsection
