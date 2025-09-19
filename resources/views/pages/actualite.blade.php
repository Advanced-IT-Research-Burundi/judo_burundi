@extends('layouts.user')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/actualites.css') }}">
@endpush

@section('content')
<section class="news-detail">
    <div class="container">
        <!-- Image -->
        <div class="news-image-large mb-4">
            @if($actualite->image && file_exists(public_path('storage/' . $actualite->image)))
                <img src="{{ asset('storage/' . $actualite->image) }}" 
                     alt="{{ $actualite->titre }}" 
                     style="width:100%; border-radius:10px;">
            @else
                <img src="/images/judo6.jpg" alt="Actualité" style="width:100%; border-radius:10px;">
            @endif
        </div>

        <!-- Meta infos -->
        <div class="news-meta mb-2">
            <span class="news-date">{{ $actualite->date_post->format('d M Y') }}</span> |
            <span class="news-category">{{ $actualite->typePost->nom ?? 'Actualité' }}</span> |
            <span class="news-author">Par {{ $actualite->user->name ?? 'Fédération de Judo' }}</span>
        </div>

        <!-- Titre -->
        <h1 class="news-title mb-4">{{ $actualite->titre }}</h1>

        <!-- Contenu -->
        <div class="news-content">
            {!! $actualite->contenu !!}
        </div>

        <!-- Bouton retour -->
        <div class="mt-5">
            <a href="{{ route('actualites.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour aux actualités
            </a>
        </div>
    </div>
</section>
@endsection
