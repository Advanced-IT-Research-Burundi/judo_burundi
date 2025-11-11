@extends('layouts.admin')
@section('title', 'Ajouter une Compétition')
@section('page-title', 'Ajouter une Compétition')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.competitions.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <!-- Nom -->
                <div class="col-md-6">
                    <label class="form-label">Nom <span class="text-danger">*</span></label>
                    <input name="nom" class="form-control" required>
                </div>

                <!-- Lieu -->
                <div class="col-md-6">
                    <label class="form-label">Lieu</label>
                    <input name="lieu" class="form-control">
                </div>

                <!-- Type (Select) -->
                <div class="col-md-6">
                    <label class="form-label">Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select" required>
                        <option value="">-- Sélectionner un type --</option>
                        <option value="Cadets">Cadets</option>
                        <option value="Benjamins">Benjamins</option>
                        <option value="Minimes">Minimes</option>
                        <option value="Juniors">Juniors</option>
                        <option value="Séniors">Séniors</option>
                        <option value="Kata">Kata</option>
                    </select>
                </div>

                <!-- Saison -->
                <div class="col-md-6">
                    <label class="form-label">Saison</label>
                    <input name="saison" class="form-control" placeholder="Ex: 2024-2025">
                </div>

                <!-- Date -->
                <div class="col-md-4">
                    <label class="form-label">Date de compétition</label>
                    <input type="date" name="date_competition" class="form-control">
                </div>



                <!-- Club Domicile -->
                <div class="col-md-4">
                    <label class="form-label">Club Domicile</label>
                    <select name="clubdomicil_id" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Club Adversaire -->
                <div class="col-md-4">
                    <label class="form-label">Club Adversaire</label>
                    <select name="clubadversaire_id" class="form-select">
                        <option value="">-- Sélectionner --</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                {{-- <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div> --}}

                <!-- Résultat Détaillé avec Summernote -->
                <div class="col-12">
                    <label class="form-label">Résultat Détaillé</label>
                    <textarea name="resultat" id="resultat_editor" class="form-control"></textarea>
                    <small class="text-muted">Utilisez l'éditeur pour saisir les résultats détaillés (participants, médailles, statistiques, etc.)</small>
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('admin.competitions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>Annuler
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i>Enregistrer
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
