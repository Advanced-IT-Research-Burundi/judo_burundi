@extends('layouts.user')

@section('title', 'Contact — Fédération de Judo du Burundi')

@push('styles')
    @include('partials.contact-styles')
@endpush

@section('content')
<section class="page-hero dark-overlay gradient-overlay"
         style="background-image: url('{{ asset('images/judo5.jpg') }}');">
    <div class="page-hero-content">
        <h1 class="fw-bold display-6">Contactez-nous</h1>
        <p class="mb-0 mx-auto" style="max-width: 36rem;">
            Une question sur les clubs, les compétitions ou l’adhésion&nbsp;?
            Envoyez-nous un message — la <strong>Fédération Burundaise de Judo et Disciplines Associées</strong> vous répond.
        </p>
        <div class="page-hero-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Accueil</a>
            <i class="fas fa-chevron-right"></i>
            <span>Contact</span>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        <div class="row g-5 g-xl-5 align-items-start">
            {{-- Colonne gauche : intro + grille 2×2 + réseaux --}}
            <div class="col-lg-6">
                @include('partials.contact-coordonnees')
            </div>

            {{-- Colonne droite : formulaire dans un bloc teinté (comme la maquette) --}}
            <div class="col-lg-6">
                @include('partials.contact-form', ['idSuffix' => ''])
            </div>
        </div>
    </div>
</section>

{{-- Carte large comme sur la référence --}}
<section class="pb-5 bg-white">
    <div class="container-fluid px-0 px-md-3">
        <div class="container">
            <h2 class="h5 fw-bold text-primary text-center mb-4">Notre localisation</h2>
        </div>
        <div class="contact-page-map px-2 px-md-0">
            <iframe class="rounded-4 shadow-sm w-100"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Carte — Bujumbura"
                    src="https://maps.google.com/maps?q=Avenue+de+l'Indépendance+Bujumbura+Burundi&amp;hl=fr&amp;z=14&amp;output=embed&amp;mode=minimal">
            </iframe>
        </div>
    </div>
</section>

@endsection
