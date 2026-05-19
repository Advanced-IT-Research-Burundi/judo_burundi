{{-- admin/membres/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestion des Membres')
@section('page-title', 'Gestion des Membres')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Membres ({{ $membres->total() }})</h5>
    </div>
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
            <div class="text-muted small">
                Affichage de {{ $membres->firstItem() ?? 0 }} à {{ $membres->lastItem() ?? 0 }} sur {{ $membres->total() }} membres
            </div>
            <a href="{{ route('admin.membres.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouveau membre
            </a>
        </div>

        <div class="row g-3 admin-grid-card">
            @forelse($membres as $membre)
                @php
                    $photoUrl = $membre->imageUrl();
                    $initials = collect(preg_split('/\s+/', trim((string) ($membre->fullname ?? '')), -1, PREG_SPLIT_NO_EMPTY))
                        ->take(2)
                        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                        ->implode('');
                    if ($initials === '') {
                        $initials = '—';
                    }
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm overflow-hidden">
                        <div class="admin-membre-thumb border-bottom">
                            @if($photoUrl)
                                <div class="ratio ratio-4x3">
                                    <img src="{{ $photoUrl }}"
                                         class="rounded-top"
                                         alt="Photo — {{ $membre->fullname }}"
                                         loading="lazy"
                                         decoding="async">
                                </div>
                            @else
                                <div class="ratio ratio-4x3 d-flex align-items-center justify-content-center bg-body-secondary">
                                    <div class="avatar text-uppercase" style="width: 72px; height: 72px; font-size: 1.35rem;">
                                        {{ $initials }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $membre->fullname }}</h5>
                            @if($membre->description)
                                <p class="card-text text-muted small">{{ Str::limit($membre->description, 80) }}</p>
                            @endif
                            <div class="mb-2">
                                <small class="text-muted text-break">
                                    <i class="fas fa-envelope me-1"></i>{{ $membre->email }}
                                </small>
                            </div>
                            @if($membre->telephone)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $membre->telephone }}
                                    </small>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-top">
                            <div class="btn-group btn-group-sm w-100 admin-table-actions" role="group" aria-label="Actions membre">
                                <a href="{{ route('admin.membres.show', $membre) }}" class="btn btn-outline-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.membres.edit', $membre) }}" class="btn btn-outline-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.membres.destroy', $membre) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-inbox fa-4x mb-3"></i>
                    <p>Aucun membre trouvé.</p>
                </div>
            @endforelse
        </div>
    </div>
    @if($membres->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $membres->currentPage() }} / {{ $membres->lastPage() }}</div>
            <div>{{ $membres->links() }}</div>
        </div>
    @endif
</div>
@endsection
