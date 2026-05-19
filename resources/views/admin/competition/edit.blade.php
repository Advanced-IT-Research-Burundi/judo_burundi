@extends('layouts.admin')
@section('title', 'Modifier une Compétition')
@section('page-title', 'Modifier une Compétition')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-trophy me-2"></i>Modifier la compétition</h5>
        <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.competitions.update', $competition->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input name="nom" value="{{ old('nom', $competition->nom) }}" class="form-control @error('nom') is-invalid @enderror" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lieu</label>
                    <input name="lieu" value="{{ old('lieu', $competition->lieu) }}" class="form-control @error('lieu') is-invalid @enderror">
                    @error('lieu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">-- Sélectionner un type --</option>
                        @foreach(['Cadets','Benjamins','Minimes','Juniors','Séniors','Kata'] as $type)
                            <option value="{{ $type }}" @selected(old('type', $competition->type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Saison</label>
                    <input name="saison" value="{{ old('saison', $competition->saison) }}" class="form-control @error('saison') is-invalid @enderror" placeholder="Ex: 2024-2025">
                    @error('saison')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date de compétition</label>
                    <input type="date" name="date_competition" value="{{ old('date_competition', optional($competition->date_competition)->format('Y-m-d')) }}" class="form-control @error('date_competition') is-invalid @enderror">
                    @error('date_competition')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Club Domicile</label>
                    <select name="clubdomicil_id" class="form-select @error('clubdomicil_id') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" @selected(old('clubdomicil_id', $competition->clubdomicil_id) == $club->id)>{{ $club->nom }}</option>
                        @endforeach
                    </select>
                    @error('clubdomicil_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Club Adversaire</label>
                    <select name="clubadversaire_id" class="form-select @error('clubadversaire_id') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" @selected(old('clubadversaire_id', $competition->clubadversaire_id) == $club->id)>{{ $club->nom }}</option>
                        @endforeach
                    </select>
                    @error('clubadversaire_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @php
                    $extraClubIds = old('club_ids', $competition->clubs->pluck('id')->all());
                @endphp

                <div class="col-12">
                    <label class="form-label">Autres clubs participants</label>
                    <select name="club_ids[]" class="form-select @error('club_ids') is-invalid @enderror" multiple size="6">
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}" @selected(in_array($club->id, $extraClubIds, true))>{{ $club->nom }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Conserver Ctrl (ou Cmd) pour en choisir plusieurs — en complément des clubs domicile et adversaire.</small>
                    @error('club_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $competition->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Résultat Détaillé</label>
                    <textarea name="resultat" id="resultat_editor" class="form-control @error('resultat') is-invalid @enderror">{{ old('resultat', $competition->resultat) }}</textarea>
                    <small class="text-muted">Utilisez l'éditeur pour saisir les résultats détaillés (participants, médailles, statistiques, etc.)</small>
                    @error('resultat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery (requis pour Summernote) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS (requis pour Summernote) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script>
$(document).ready(function() {
    // Initialiser Summernote
    $('#resultat_editor').summernote({
        height: 300,
        placeholder: 'Saisissez les résultats détaillés de la compétition...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Validation du formulaire
    $('form').on('submit', function(e) {
        var nom = $('input[name="nom"]').val();
        var type = $('select[name="type"]').val();

        if (!nom || !type) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires (*)');
            return false;
        }
    });
});
</script>
@endpush
