@extends('layouts.admin')

@section('title', 'Détails de l’actualité')
@section('page-title', 'Détails de l’actualité')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <h5><i class="fas fa-newspaper me-2"></i>{{ $post->title }}</h5>
    </div>
    <div class="card-body">
        @if($post->image)
            <div class="text-center mb-3">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid rounded" style="max-height: 300px;">
            </div>
        @endif

        <p class="text-muted small mb-3">
            <i class="fas fa-calendar me-1"></i>Publié le {{ $post->created_at->format('d/m/Y à H:i') }}
        </p>

        <div class="mb-3">{!! nl2br(e($post->content)) !!}</div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>
@endsection
