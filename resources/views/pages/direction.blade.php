@extends('layouts.user')

@section('title', 'Direction - Fédération de Judo du Burundi')

@section('content')
<section class="direction-hero page-hero gradient-overlay text-white" style="background-image: url('{{ asset('images/judo1.jpeg') }}');">
    <div class="container position-relative">
        <div class="page-hero-content text-center py-5">
            <h1 class="display-6 fw-bold text-uppercase">Direction</h1>
            <p class="mb-0 opacity-75">Les membres du bureau fédéral de la Fédération Burundaise de Judo</p>
        </div>
    </div>
</section>

<section class="direction-section bg-white overflow-hidden">
    <div class="container py-5">
        {{-- Aligné sur la grille type fédération (titre à gauche, cartes portrait) --}}
        <h2 class="bureau-fed-title fw-bold text-dark mb-2">Le bureau fédéral</h2>
        <p class="text-muted mb-4 small">Fédération Burundaise de Judo et Disciplines Associées</p>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 g-lg-4">
            @forelse($equipes as $membre)
                <div class="col">
                    <div class="card h-100 border shadow-sm bureau-member-card rounded-2 overflow-hidden">
                        <div class="bureau-member-photo-wrap">
                            @if($membre->photo)
                                <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->fullname }}">
                            @else
                                <img src="{{ asset('images/default-user.png') }}" alt="Photo par défaut">
                            @endif
                        </div>
                        <div class="card-body py-3 px-2 px-sm-3">
                            <h3 class="bureau-member-name lh-sm mb-1 fs-6 fw-semibold">{{ $membre->fullname }}</h3>
                            @if($membre->poste)
                                <p class="bureau-member-role small text-muted text-uppercase mb-2 mb-lg-3">{{ $membre->poste }}</p>
                            @endif
                            @if($membre->email || $membre->telephone)
                                <div class="d-flex gap-2 justify-content-start flex-wrap small bureau-contact-icons">
                                    @if($membre->email)
                                        <a href="mailto:{{ $membre->email }}" class="text-secondary" title="E-mail"><i class="fas fa-envelope"></i></a>
                                    @endif
                                    @if($membre->telephone)
                                        <a href="tel:{{ $membre->telephone }}" class="text-secondary" title="Téléphone"><i class="fas fa-phone"></i></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info mb-0" role="alert">
                        <i class="fas fa-info-circle bureau-alert-icon me-2"></i>
                        Aucun membre du bureau fédéral n'est disponible pour le moment.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mission-panel card border shadow-sm rounded-4 mx-auto mt-5">
            <div class="card-body p-4 p-lg-5 text-center mission-panel-inner">
                <h3 class="h4 fw-bold text-primary mb-3">Notre mission</h3>
                <p class="text-muted mb-0 lh-lg">
                    Le comité exécutif travaille en étroite collaboration avec les clubs affiliés,
                    les entraîneurs et les athlètes pour promouvoir le judo et assurer son développement
                    à travers tout le pays. Ensemble, nous formons les champions de demain tout en
                    transmettant les valeurs fondamentales du judo : courtoisie, courage, honnêteté,
                    honneur, modestie, respect, maîtrise de soi et amitié.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Animation discrète du bloc mission (évite tout effet qui casse la hauteur / le scroll) */
.mission-panel-inner { opacity: 1; transform: none; transition: opacity 0.5s ease, transform 0.5s ease; }
.mission-panel-inner.is-visible { opacity: 1; transform: translateY(0); }
@media (prefers-reduced-motion: reduce) {
    .mission-panel-inner { transition: none; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var panel = document.querySelector('.mission-panel-inner');
    if (!panel || !('IntersectionObserver' in window)) return;
    panel.style.opacity = '0';
    panel.style.transform = 'translateY(12px)';
    var obs = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                entry.target.style.opacity = '';
                entry.target.style.transform = '';
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    obs.observe(panel);
});
</script>
@endpush
