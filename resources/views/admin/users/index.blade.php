@extends('layouts.admin')

@section('title', 'Utilisateurs')
@section('page-title', 'Utilisateurs')

@push('styles')
<style>
    .users-word-cloud {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 0.4rem 0.95rem;
        padding: 1.75rem 1.25rem;
        min-height: 140px;
        background: linear-gradient(165deg, #f9fafc 0%, #e8ecf5 100%);
        border-radius: 12px;
        border: 1px solid rgba(15, 23, 42, 0.07);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    .users-word-cloud .cloud-chip {
        text-decoration: none;
        transition: transform 0.14s ease, filter 0.14s ease;
        line-height: 1.15;
        font-weight: 600;
        letter-spacing: -0.02em;
    }
    .users-word-cloud .cloud-chip:hover {
        transform: scale(1.06);
        filter: brightness(1.05);
        text-decoration: none;
    }
    .users-word-cloud .cloud-sub {
        font-weight: 400;
        font-size: 0.72em;
        opacity: 0.78;
        margin-left: 0.2rem;
    }
</style>
@endpush

@section('content')
{{-- <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0"><i class="fas fa-cloud me-2"></i>Aperçu ({{ $usersForCloud->count() }} utilisateurs)</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm text-primary">
            <i class="fas fa-plus me-1"></i>Nouvel utilisateur
        </a>
    </div>
    <div class="card-body">
        <div class="users-word-cloud">
            @foreach($usersForCloud as $user)
                <a href="{{ route('admin.users.edit', $user) }}" class="cloud-chip badge rounded-pill bg-primary">
                    {{ $user->name ?: $user->email }}
                    <span class="cloud-sub">{{ $user->email }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div> --}}

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Détail et actions</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>E-mail</th>
                        <th>Rôle</th>
                        <th>Inscription</th>
                        <th class="text-end" style="min-width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $row)
                        <tr>
                            <td>{{ $row->name ?: '—' }}</td>
                            <td><small>{{ $row->email }}</small></td>
                            <td>
                                @if($row->is_admin)
                                    <span class="badge bg-primary">Admin</span>
                                @else
                                    <span class="badge bg-secondary">Membre</span>
                                @endif
                            </td>
                            <td>{{ $row->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm admin-table-actions" role="group" aria-label="Actions utilisateur">
                                    <a href="{{ route('admin.users.edit', $row) }}" class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($row->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $row) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Aucun utilisateur.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted small">Page {{ $users->currentPage() }} / {{ $users->lastPage() }}</div>
            <div>{{ $users->links() }}</div>
        </div>
    @endif
</div>
@endsection
