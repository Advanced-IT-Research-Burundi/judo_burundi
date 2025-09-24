@extends('layouts.admin')

@section('title', $post->titre)
@section('page-title', 'Aperçu de l\'Article')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $post->titre }}</h5>
                        <div class="d-flex gap-2 mt-2">
                            <span class="badge bg-info">{{ $post->typePost->nom }}</span>
                            @if($post->niveau_competition)
                                {{-- <span class="badge bg-{{ formatNiveauCompetition($post->niveau_competition)['class'] }}">
                                    <i class="{{ formatNiveauCompetition($post->niveau_competition)['icon'] }} me-1"></i>
                                    {{ $post->niveau_competition }}
                                </span> --}}
                            @endif
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </div>
                
                @if($post->image)
                    <img src="{{ Storage::url($post->image) }}" class="card-img-top" style="height: 300px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <!-- Métadonnées -->
                    <div class="row mb-4 p-3 bg-light rounded">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <strong>Publié le :</strong> {{ $post->date_post_formatee }}<br>
                                <strong>Auteur :</strong> {{ $post->user->name ?? 'Administrateur' }}<br>
                                <strong>Type :</strong> {{ $post->typePost->nom }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            @if($post->lieu_evenement || $post->date_evenement_debut)
                                <small class="text-muted">
                                    @if($post->lieu_evenement)
                                        <strong>Lieu :</strong> {{ $post->lieu_evenement }}<br>
                                    @endif
                                    @if($post->date_evenement_debut)
                                        <strong>Date événement :</strong> 
                                        {{ $post->date_evenement_debut->format('d/m/Y à H:i') }}
                                        @if($post->date_evenement_fin && $post->date_evenement_fin != $post->date_evenement_debut)
                                            - {{ $post->date_evenement_fin->format('d/m/Y à H:i') }}
                                        @endif
                                        <br>
                                    @endif
                                    @if($post->duree_evenement)
                                        <strong>Durée :</strong> {{ $post->duree_evenement }} jour(s)
                                    @endif
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="article-content">
                        {!! nl2br(e($post->contenu)) !!}
                    </div>

                    <!-- Résultats -->
                    @if($post->resultats)
                        <div class="mt-4">
                            <h6 class="text-primary border-bottom pb-2">
                                <i class="fas fa-trophy me-2"></i>Résultats
                            </h6>
                            <div class="bg-light p-3 rounded">
                                {!! nl2br(e($post->resultats)) !!}
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if($post->status === 'draft')
                                <button class="btn btn-success" 
                                        onclick="toggleStatus({{ $post->id }}, '{{ $post->status }}')">
                                    <i class="fas fa-paper-plane me-2"></i>Publier
                                </button>
                            @else
                                {{-- <button class="btn btn-warning" 
                                        onclick="toggleStatus({{ $post->id }}, '{{ $post->status }}')">
                                    <i class="fas fa-archive me-2"></i>Mettre en brouillon
                                </button> --}}
                            @endif
                        </div>
                        <div>
                            <small class="text-muted">
                                Dernière modification : {{ $post->updated_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        text-align: justify;
    }
    .article-content p {
        margin-bottom: 1.2rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleStatus(postId, currentStatus) {
        const newStatus = currentStatus === 'published' ? 'draft' : 'published';
        const message = newStatus === 'published' ? 'Publier cet article ?' : 'Mettre cet article en brouillon ?';
        
        if (confirm(message)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/posts/${postId}/toggle-status`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PATCH';
            
            form.appendChild(csrfToken);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush