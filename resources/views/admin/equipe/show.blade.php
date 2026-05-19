@extends('layouts.admin')

@section('title', $equipe->fullname)
@section('page-title', 'Détails — Équipe fédérale')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>{{ $equipe->fullname }}</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.equipes.index') }}" class="btn btn-secondary btn-sm">Retour</a>
            <a href="{{ route('admin.equipes.edit', $equipe) }}" class="btn btn-light btn-sm text-primary">
                <i class="fas fa-edit me-1"></i>Modifier
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4 align-items-start">
            <div class="col-md-4 col-lg-3 text-center text-md-start">
                @if($url = $equipe->photoUrl())
                    <img src="{{ $url }}"
                         class="img-fluid rounded-circle admin-membre-avatar-xl d-block mx-auto mx-md-0"
                         alt="Photo — {{ $equipe->fullname }}"
                         loading="lazy"
                         decoding="async">
                @else
                    @php
                        $initials = collect(preg_split('/\s+/', trim((string) ($equipe->fullname ?? '')), -1, PREG_SPLIT_NO_EMPTY))
                            ->take(2)
                            ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                            ->implode('');
                    @endphp
                    <div class="rounded-circle bg-body-secondary border d-inline-flex align-items-center justify-content-center admin-membre-avatar-xl mx-auto mx-md-0"
                         style="background: linear-gradient(145deg, #e8f0e3, #f1f4f8); border-color: rgba(26, 54, 93, 0.12) !important;">
                        <span class="display-6 text-primary fw-bold text-uppercase" style="font-size: 3rem;">{{ $initials !== '' ? $initials : '?' }}</span>
                    </div>
                @endif
            </div>
            <div class="col-md-8 col-lg-9">
                @if($equipe->poste)
                    <p class="text-muted mb-4 mb-md-0">
                        <i class="fas fa-briefcase text-success me-2"></i>{{ $equipe->poste }}
                    </p>
                @else
                    <p class="text-muted fst-italic small">Aucun poste renseigné.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
