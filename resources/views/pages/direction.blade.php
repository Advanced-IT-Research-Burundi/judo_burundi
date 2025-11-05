@extends('layouts.user')

@section('title', 'Direction - Fédération de Judo du Burundi')
@section('content')
<section class="page-hero gradient-overlay" style="background-image: url('{{ asset('images/judo1.jpeg') }}');">
    <div class="page-hero-content text-center">
        <h1>Direction</h1>
        <p>Les membres du comité exécutif de la Fédération Burundaise de Judo</p>
    </div>
</section>

<section class="direction-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">Comité Exécutif</h2>

        <div class="row justify-content-center">
            @foreach($equipes as $membre)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card text-center shadow border-0 rounded-3 h-100">
                        @if($membre->photo)
                            <img src="{{ asset('storage/' . $membre->photo) }}" class="card-img-top rounded-top" alt="{{ $membre->fullname }}">
                        @else
                            <img src="{{ asset('images/default-user.png') }}" class="card-img-top rounded-top" alt="Photo par défaut">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $membre->fullname }}</h5>
                            <p class="card-text text-muted">{{ $membre->poste ?? 'Membre' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <p>
                Le comité travaille en étroite collaboration avec les clubs affiliés, les entraîneurs et les athlètes 
                pour promouvoir le judo et assurer son développement à travers tout le pays.
            </p>
        </div>
    </div>
</section>
@endsection
