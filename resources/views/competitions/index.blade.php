@extends('layouts.user')

@section('title', 'Liste des Compétitions')

@section('content')
<div class="container-fluid mt-4 px-4">

    <!-- HEADER -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="mb-2 fw-bold">Compétitions de Judo</h1>
            <p class="text-muted">Retrouvez toutes les compétitions et leurs résultats</p>
        </div>
        <div class="col-md-6 text-end">
            <div class="badge bg-primary fs-6 px-3 py-2">
                <i class="fas fa-calendar-check me-2"></i>
                {{ $competitions->total() }} compétitions
            </div>
        </div>
    </div>

    <!-- BARRE DE RECHERCHE ET FILTRES -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body p-4">
            <div class="row g-3">
                <!-- BARRE DE RECHERCHE -->
                <div class="col-md-12 mb-3">
                    <div class="input-group input-group-lg search-bar">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" 
                               id="searchInput" 
                               class="form-control border-start-0 ps-0" 
                               placeholder="Rechercher une compétition par nom, lieu, club...">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- FILTRES -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-2">
                        <i class="fas fa-calendar me-1"></i> ANNÉE
                    </label>
                    <select name="year" id="yearFilter" class="form-select custom-select">
                        <option value="">Toutes les années</option>
                        @foreach(range(date('Y')+1, date('Y')-5) as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected':'' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-2">
                        <i class="fas fa-map-marker-alt me-1"></i> LIEU
                    </label>
                    <select name="lieu" id="lieuFilter" class="form-select custom-select">
                        <option value="">Tous les lieux</option>
                        @foreach($lieux as $lieu)
                            <option value="{{ $lieu }}" {{ request('lieu') == $lieu ? 'selected':'' }}>{{ $lieu }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-muted small mb-2">
                        <i class="fas fa-tag me-1"></i> CATÉGORIE
                    </label>
                    <select name="type" id="typeFilter" class="form-select custom-select">
                        <option value="">Toutes catégories</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected':'' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button onclick="resetFilters()" class="btn btn-outline-danger w-100">
                        <i class="fas fa-redo me-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- RÉSULTATS -->
    <div id="resultsInfo" class="mb-3 text-muted">
        <span id="resultCount">{{ $competitions->count() }}</span> résultat(s) trouvé(s)
    </div>

    <!-- LISTE DES COMPÉTITIONS -->
    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 competition-table">
                <thead>
                    <tr>
                        <th style="width: 120px;" class="text-center">DATE</th>
                        <th style="width: 70px;"></th>
                        <th>COMPÉTITION</th>
                        <th style="width: 280px;">LIEU</th>
                        <th style="width: 180px;" class="text-end">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="competitionsTableBody">
                    @forelse($competitions as $competition)
                    <tr class="competition-row" data-competition-id="{{ $competition->id }}">
                        <!-- DATE -->
                        <td class="text-center date-cell">
                            <div class="date-wrapper">
                                <div class="month-label">{{ \Carbon\Carbon::parse($competition->date_competition)->translatedFormat('F') }}</div>
                                <div class="day-label">{{ \Carbon\Carbon::parse($competition->date_competition)->format('d') }}</div>
                            </div>
                        </td>

                        <!-- LOGO/ICONE -->
                        <td class="text-center">
                            <div class="competition-icon">
                                <i class="fas fa-medal"></i>
                            </div>
                        </td>

                        <!-- INFORMATIONS COMPÉTITION -->
                        <td class="competition-info">
                            <h6 class="competition-name mb-1">{{ $competition->nom }}</h6>
                            <div class="competition-details">
                                @if($competition->clubdomicile && $competition->clubadversaire)
                                    <span class="badge bg-light text-dark me-1">
                                        <i class="fas fa-home me-1"></i>{{ $competition->clubdomicile->nom }}
                                    </span>
                                    <span class="text-muted mx-1">vs</span>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-users me-1"></i>{{ $competition->clubadversaire->nom }}
                                    </span>
                                @else
                                    <span class="badge bg-info text-white">
                                        <i class="fas fa-trophy me-1"></i>{{ $competition->type ?? 'Compétition' }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- LIEU -->
                        <td class="location-cell">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <span class="fw-semibold">{{ $competition->lieu ?? 'Non spécifié' }}</span>
                        </td>

                        <!-- ACTIONS -->
                        <td class="text-end action-cell">
                            @if($competition->resultat)
                                <a href="{{ route('competitions.result', $competition->id) }}" 
                                   class="btn btn-sm btn-primary action-btn me-2">
                                    <i class="fas fa-chart-bar me-1"></i>Résultats
                                </a>
                                {{-- <a href="{{ route('competitions.draw', $competition->id) }}" 
                                   class="btn btn-sm btn-outline-secondary action-btn">
                                    <i class="fas fa-sitemap me-1"></i>Tableau
                                </a> --}}
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>À venir
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="noResults">
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-4x mb-3 text-muted"></i>
                                <h5 class="text-muted">Aucune compétition trouvée</h5>
                                <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
        {{ $competitions->appends(request()->query())->links() }}
    </div>

</div>

<style>
    /* VARIABLES */
    :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --success-color: #198754;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --light-bg: #f8f9fa;
        --border-color: #dee2e6;
        --hover-bg: #f1f3f5;
        --shadow: 0 2px 8px rgba(0,0,0,0.08);
        --shadow-hover: 0 4px 16px rgba(0,0,0,0.12);
    }

    /* GLOBAL */
    body {
        background-color: #f5f7fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* CARDS */
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: var(--shadow-hover);
    }

    /* SEARCH BAR */
    .search-bar {
        box-shadow: var(--shadow);
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .search-bar:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        transform: translateY(-2px);
    }

    .search-bar .input-group-text {
        border: 1px solid var(--border-color);
    }

    .search-bar .form-control {
        border: 1px solid var(--border-color);
        font-size: 1rem;
    }

    .search-bar .form-control:focus {
        box-shadow: none;
        border-color: var(--border-color);
    }

    #clearSearch {
        border: 1px solid var(--border-color);
        background-color: white;
        transition: all 0.3s ease;
    }

    #clearSearch:hover {
        background-color: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
    }

    /* CUSTOM SELECT */
    .custom-select {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.6rem 0.75rem;
        transition: all 0.3s ease;
        background-color: white;
    }

    .custom-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
    }

    .custom-select:hover {
        border-color: var(--primary-color);
    }

    /* TABLE */
    .competition-table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .competition-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .competition-table thead th {
        padding: 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        border: none;
        text-transform: uppercase;
    }

    .competition-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid var(--border-color);
    }

    .competition-table tbody tr:hover {
        background-color: var(--hover-bg);
        transform: scale(1.01);
        box-shadow: var(--shadow);
    }

    .competition-table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
    }

    /* DATE CELL */
    .date-cell {
        padding: 0.5rem !important;
    }

    .date-wrapper {
        display: inline-block;
        text-align: center;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        color: white;
        box-shadow: var(--shadow);
    }

    .month-label {
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .day-label {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
        margin-top: 0.25rem;
    }

    /* COMPETITION ICON */
    .competition-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
    }

    .competition-row:hover .competition-icon {
        transform: rotate(10deg) scale(1.1);
    }

    /* COMPETITION INFO */
    .competition-name {
        font-weight: 700;
        color: #2d3748;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    .competition-details {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .competition-details .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
    }

    /* LOCATION CELL */
    .location-cell {
        font-size: 0.95rem;
        color: #4a5568;
    }

    /* ACTION BUTTONS */
    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .btn-primary.action-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary.action-btn:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    /* BADGES */
    .badge {
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 8px;
    }

    /* EMPTY STATE */
    .empty-state {
        padding: 3rem 0;
    }

    .empty-state i {
        opacity: 0.5;
    }

    /* ANIMATIONS */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .competition-row {
        animation: fadeIn 0.5s ease forwards;
    }

    .competition-row:nth-child(1) { animation-delay: 0.05s; }
    .competition-row:nth-child(2) { animation-delay: 0.1s; }
    .competition-row:nth-child(3) { animation-delay: 0.15s; }
    .competition-row:nth-child(4) { animation-delay: 0.2s; }
    .competition-row:nth-child(5) { animation-delay: 0.25s; }

    /* LOADING STATE */
    .loading {
        pointer-events: none;
        opacity: 0.6;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .competition-table {
            font-size: 0.85rem;
        }

        .date-wrapper {
            padding: 0.4rem 0.8rem;
        }

        .day-label {
            font-size: 1.2rem;
        }

        .action-btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }

        .competition-icon {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }

    /* SCROLL BAR */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--secondary-color);
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-color);
    }
</style>

<script>
    // VARIABLES GLOBALES
    let searchTimeout;
    const searchDelay = 300; // ms

    // INITIALISATION
    document.addEventListener('DOMContentLoaded', function() {
        initializeFilters();
        initializeSearch();
        updateResultCount();
    });

    // FILTRES
    function initializeFilters() {
        const yearFilter = document.getElementById('yearFilter');
        const lieuFilter = document.getElementById('lieuFilter');
        const typeFilter = document.getElementById('typeFilter');

        if (yearFilter) yearFilter.addEventListener('change', applyFilters);
        if (lieuFilter) lieuFilter.addEventListener('change', applyFilters);
        if (typeFilter) typeFilter.addEventListener('change', applyFilters);
    }

    function applyFilters() {
        const year = document.getElementById('yearFilter').value;
        const lieu = document.getElementById('lieuFilter').value;
        const type = document.getElementById('typeFilter').value;
        const search = document.getElementById('searchInput').value;

        const params = new URLSearchParams();
        if (year) params.append('year', year);
        if (lieu) params.append('lieu', lieu);
        if (type) params.append('type', type);
        if (search) params.append('search', search);

        // Animation de chargement
        document.getElementById('competitionsTableBody').classList.add('loading');

        window.location.href = '{{ route("competitions.index") }}?' + params.toString();
    }

    function resetFilters() {
        document.getElementById('yearFilter').value = '';
        document.getElementById('lieuFilter').value = '';
        document.getElementById('typeFilter').value = '';
        document.getElementById('searchInput').value = '';
        
        window.location.href = '{{ route("competitions.index") }}';
    }

    // RECHERCHE
    function initializeSearch() {
        const searchInput = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearSearch');

        if (searchInput) {
            // Restaurer la valeur de recherche depuis l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchParam = urlParams.get('search');
            if (searchParam) {
                searchInput.value = searchParam;
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                
                if (this.value.length > 0) {
                    clearButton.style.display = 'block';
                } else {
                    clearButton.style.display = 'none';
                }

                searchTimeout = setTimeout(() => {
                    performSearch(this.value);
                }, searchDelay);
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(searchTimeout);
                    performSearch(this.value);
                }
            });
        }

        if (clearButton) {
            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                clearButton.style.display = 'none';
                performSearch('');
            });

            // Afficher le bouton si il y a une recherche active
            if (searchInput.value.length > 0) {
                clearButton.style.display = 'block';
            }
        }
    }

    function performSearch(searchTerm) {
        const rows = document.querySelectorAll('.competition-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(searchTerm.toLowerCase());

            if (matches || searchTerm === '') {
                row.style.display = '';
                visibleCount++;
                // Animation de réapparition
                row.style.animation = 'fadeIn 0.5s ease forwards';
            } else {
                row.style.display = 'none';
            }
        });

        // Mettre à jour le compteur
        updateResultCount(visibleCount);

        // Afficher message si aucun résultat
        showNoResults(visibleCount === 0);
    }

    function updateResultCount(count = null) {
        const resultCountElement = document.getElementById('resultCount');
        if (resultCountElement) {
            if (count === null) {
                count = document.querySelectorAll('.competition-row:not([style*="display: none"])').length;
            }
            resultCountElement.textContent = count;
        }
    }

    function showNoResults(show) {
        let noResultsRow = document.getElementById('noResults');
        
        if (show) {
            if (!noResultsRow) {
                const tbody = document.getElementById('competitionsTableBody');
                noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResults';
                noResultsRow.innerHTML = `
                    <td colspan="5" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-search fa-4x mb-3 text-muted"></i>
                            <h5 class="text-muted">Aucun résultat trouvé</h5>
                            <p class="text-muted">Essayez de modifier votre recherche</p>
                        </div>
                    </td>
                `;
                tbody.appendChild(noResultsRow);
            }
            noResultsRow.style.display = '';
        } else {
            if (noResultsRow) {
                noResultsRow.style.display = 'none';
            }
        }
    }

    // ANIMATIONS AU SCROLL
    function handleScrollAnimations() {
        const rows = document.querySelectorAll('.competition-row');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        rows.forEach(row => {
            observer.observe(row);
        });
    }

    // Appeler au chargement
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', handleScrollAnimations);
    } else {
        handleScrollAnimations();
    }
</script>
@endsection