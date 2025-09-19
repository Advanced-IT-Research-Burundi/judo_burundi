@section('content')
    <!-- MODAL POUR LIRE LES ACTUALITÉS -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeNewsModal()" title="Fermer">&times;</span>
                <h2 id="modalTitle"></h2>
                <div class="modal-meta">
                    <span id="modalDate"></span>
                    <span id="modalAuthor"></span>
                    <span id="modalCategory"></span>
                </div>
            </div>
            <div class="modal-body">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/actualites.js') }}"></script>
@endpush