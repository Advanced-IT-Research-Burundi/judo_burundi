@extends('layouts.user')

@section('title', 'Historique - Fédération de Judo du Burundi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/history-about.css') }}">
@endpush

@section('content')
<div class="history-page pb-5">
    {{-- Carrousel (structure type fédération) --}}
    <div id="historyCarousel" class="carousel slide history-carousel" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#historyCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#historyCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#historyCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/judo1.jpeg') }}" class="d-block w-100" alt="Judo au Burundi">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/judo2.jpg') }}" class="d-block w-100" alt="Judo au Burundi">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/judo3.jpg') }}" class="d-block w-100" alt="Judo au Burundi">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#historyCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#historyCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

    <div class="container py-5 text-center border-bottom mb-5">
        <h1 class="history-intro-title fw-bold text-primary mb-3">Le judo, l'école de la vie</h1>
        <p class="history-values-line text-muted mb-0 px-2">
            La politesse — Le courage — La sincérité — L'honneur — La modestie — Le respect — Le contrôle de soi — L'amitié
        </p>
    </div>

    <div class="container pb-5">
        <div class="row g-4 g-xl-5">
            {{-- Colonne principale : récit historique --}}
            <div class="col-lg-8 history-main">

                <h2 class="fw-bold text-uppercase text-dark mb-2">Développement du judo au Burundi</h2>
                <h3 class="h5 fw-semibold text-secondary mb-3">Les débuts…</h3>

                <p class="lh-lg text-body-secondary mb-4">
                    Le judo apparaît au Burundi dans le prolongement des disciplines d'éducation physique en milieu scolaire et universitaire, puis dans les clubs civils qui se structurent peu à peu à partir des années&nbsp;1970. Comme dans plusieurs pays riverains du lac Tanganyika, les premières ceintures se forment hors de tout grand équipement : gymnases de faculté, salles communautaires, cours en plein air, avec une forte volonté pédagogique autour du respect mutuel&nbsp;(rei) et du contrôle dans l'effort.
                </p>
                <p class="lh-lg text-body-secondary mb-4">
                    Les échanges avec des formateurs régionaux, la présence d'anciens cadres ayant poursuivi une formation hors du pays, et les liens étroits entre sport scolaire et clubs associatifs contribuent à donner corps à une petite communauté judo persévérante&nbsp;: peu de tatamis au début, mais une exigence morale déjà très proche du code moral du fondateur&nbsp;Kano.
                </p>

                <figure class="my-5">
                    <img src="{{ asset('images/judo2.jpg') }}" class="img-fluid d-block mx-auto rounded shadow-sm" style="max-width: 92%;" alt="Pratique et enseignement du judo">
                    <figcaption class="small text-center text-muted mt-2 fst-italic">Transmission des valeurs à travers les générations de judoka burundais.</figcaption>
                </figure>

                <p class="history-lead-red fw-semibold mb-4">
                    Une fédération reconnue qui encadre aujourd'hui tout le mouvement : la Fédération Burundaise de Judo et Disciplines Associées.
                </p>

                <h3 class="h4 fw-bold text-dark mb-3">Naissance et structuration au Burundi…</h3>

                <p class="lh-lg text-body-secondary mb-4">
                    La structuration passe par les affiliations successive aux organismes continentaux puis mondiaux, l'organisation de stages d'unification technique et la mise en conformité progressive des règlements de compétition avec ceux de l'Union Africaine de Judo puis de la Fédération Internationale de Judo. Les clubs officiels répertorient leurs licences, désignent leurs représentants en assemblées, et désignent des cadres pour l'arbitrage comme pour l'entraînement.
                </p>
                <p class="lh-lg text-body-secondary mb-4">
                    Les années suivantes sont marquées par le renforcement du réseau de dojos, l'arrivée d'éducateurs mieux diplômés — parfois formés sous des programmes japonais, français ou régionaux — et par la diversification des catégories d'âge (écoles, cadets, seniors). À Bujumbura puis dans les autres provinces où le judo s'installe, les manifestations locales précèdent l'élargissement à des invitations internationales plus ambitieuses sur le continent.
                </p>

                <figure class="my-5">
                    <img src="{{ asset('images/judo4.jpg') }}" class="img-fluid d-block mx-auto rounded shadow-sm" style="max-width: 88%;"
                         alt="Moments du judo burundais">
                </figure>

                <h3 class="h4 fw-bold text-dark mb-3">L'apport des techniciens et partenaires de formation…</h3>

                <p class="lh-lg text-body-secondary mb-4">
                    Les stages dirigés par des experts invités permettent d'harmoniser les programmes ministériels avec les curricula internationaux. Les écoles d'arbitres bénéficient de la même rigueur : respect du règlement de compétition, sécurité des combats et exemplarité au bord du tapis sont des priorités depuis les premières compétitions interclubs.
                </p>
                <p class="lh-lg text-body-secondary mb-4">
                    La collaboration avec les fédérations voisines, les voyages encadrés des athlètes et le suivi médical léger mais adapté contribuent peu à peu à élever le niveau général tout en gardant ouverte aux plus jeunes l'entrée dans plusieurs sections découverte.
                </p>

                <h3 class="h4 fw-bold text-dark mb-3">Les actions de développement…</h3>

                <p class="lh-lg text-body-secondary mb-4">
                    La fédération s'emploie à stabiliser une couverture nationale, à éviter une concentration exclusive sur une seule grande ville et à garantir aux femmes comme aux hommes l'accès aux mêmes parcours. Les programmes hors compétition complètent le volet résolument olympique lorsque celui‑ci prend forme avec des équipes nationales présentes aux championnats d'Afrique et aux autres plateformes du judo mondial.
                </p>

                <h3 class="h4 fw-bold text-dark mt-5 mb-3">Le judo féminin et les femmes cadres du mouvement</h3>

                <p class="lh-lg text-body-secondary mb-4">
                    L'entrée progressive des cadettes et seniors féminines relève aussi bien d'une dynamique associative que du soutien des institutions locales du sport féminin. À la compétition s'ajoutent désormais davantage de rôles d'enseignement, de coaching et de gestion fédérative portés par des femmes&nbsp;: exemple nécessaire pour les jeunes générations et pour l'égalité réelle dans le choix sportif comme dans la représentation.
                </p>

                <h3 class="h4 fw-bold text-dark mt-5 mb-3">Les pionnier·e·s et les repères institutionnels du judo burundais</h3>

                <p class="lh-lg text-body-secondary mb-4">
                    Nombreux sont les adeptes fondateurs restés anonymes hors des podiums officiels&nbsp;: tenir les cours du week‑end lorsque peu d'équipements existent, réparer les tatamis, collecter des fonds pour un déplacement ou traduire notices et règles pour tout un club fait partie du récit commun. Leur souvenir reste intégré à l'histoire orale lors des cérémonies de promotion de grade, où l'accent est mis avant tout sur le «&nbsp;mieux être&nbsp;» et non uniquement la médaille.
                </p>

                <p class="small text-muted fst-italic mb-5">
                    Les précisions suivantes peuvent être complétées lorsque les archives officielles de la fédération seront centralisées.
                </p>

                <hr class="my-5">

                <h3 class="h5 fw-bold text-dark mb-3">A.&nbsp;Performances et participation sportive</h3>
                <ol class="lh-lg mb-5 ps-4">
                    <li class="mb-3"><span class="fw-semibold">Championnats d'Afrique :</span> participation et qualification des représentants du Burundi selon cycles et catégories retenus par les sélectionneurs nationaux et le calendrier de l'UJA.</li>
                    <li class="mb-3"><span class="fw-semibold">Jeux régionaux et manifestations multi-sports :</span> exposition du judo burundais auprès d'autres fédérations lors d'épreuves dans la région ou de coupes amicales invitées.</li>
                    <li class="mb-3"><span class="fw-semibold">Championnats nationaux :</span> rendez-vous pour les clubs, validations de quotas de promotion et sélection régulière d'athlètes pour les regroupements.</li>
                    <li><span class="fw-semibold">Stages et opens internationaux :</span> mise à niveau technique et sportive hors frontières avant retour d'expérience pour les juniors locaux.</li>
                </ol>

                <h3 class="h5 fw-bold text-dark mb-3">B.&nbsp;Organisation des manifestations et du calendrier fédéral</h3>
                <ol class="lh-lg mb-5 ps-4">
                    <li class="mb-3"><span class="fw-semibold">Championnats du Burundi :</span> compétitions annuelles ou semestrielles avec phases régionales puis finale nationale lorsque plusieurs clubs ou provinces sont représentées.</li>
                    <li class="mb-3"><span class="fw-semibold">Supervisions techniques :</span> contrôle du matériel, des licences et du respect des catégories âge-poids ainsi que désignation des arbitres par la commission qualifiée.</li>
                    <li><span class="fw-semibold">Événements-ponts :</span> journées scolaires, démonstrations urbaines lors de la Journée olympique nationale ou autres rendez-vous officiels du ministère.</li>
                </ol>

                <h3 class="h5 fw-bold text-dark mb-3">C.&nbsp;Burundi dans les instances internationales et partenariats</h3>
                <ol class="lh-lg mb-4 ps-4">
                    <li class="mb-3"><span class="fw-semibold">Relations UJA-IJF :</span> application des circulaires techniques et mise à niveau kata et combat selon classifications mondiales lorsque celles-ci impactent licences ou quotas.</li>
                    <li class="mb-3"><span class="fw-semibold">Accords régionaux :</span> ententes ponctuelles sur l'échange de cadres, d'arbitres et de rencontres amicales entre pays du même bassin.</li>
                    <li><span class="fw-semibold">Associations civiques :</span> actions sociales (initiation enfants, activités hors délinquance juvénile, etc.) en coordination avec les règles en vigueur.</li>
                </ol>

                <div class="text-center mt-5 pt-3 border-top">
                    <p class="text-muted small mb-3">Une question ou un témoignage pour la commission patrimoine&nbsp;?</p>
                    <a href="{{ route('contact') }}" class="btn btn-success rounded-pill px-4 shadow-sm"><i class="fas fa-envelope me-2 small"></i>Nous écrire</a>
                </div>
            </div>

            {{-- Colonne latérale : présidents --}}
            <aside class="col-lg-4">
                <div class="card shadow-sm border history-sidebar-card sticky-lg-top">
                    <div class="card-header bg-body-secondary border-bottom py-3">
                        <h2 class="h6 text-uppercase fw-bold mb-0 text-secondary text-center">Les présidents de la FBUJA</h2>
                        <p class="small text-muted text-center mb-0 mt-2">Fédération Burundaise de Judo<br>et Disciplines Associées</p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0 table-presidents align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-center">Période</th>
                                        <th scope="col" class="text-center" style="width:64px;"> </th>
                                        <th scope="col">Nom</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presidents as $mandat)
                                        <tr>
                                            <td class="text-center text-nowrap small">{{ $mandat['de'] }} – {{ $mandat['a'] }}</td>
                                            <td class="text-center p-2">
                                                @if(!empty($mandat['photo']))
                                                    <img src="{{ asset('storage/'.$mandat['photo']) }}" alt="" class="history-president-thumb rounded border">
                                                @else
                                                    <span class="d-inline-flex history-president-placeholder rounded border bg-light text-muted align-items-center justify-content-center">FB</span>
                                                @endif
                                            </td>
                                            <td class="small">{{ $mandat['nom'] ?? 'À compléter (archives fédérales)' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer small text-muted fst-italic">
                        Liste indicative — merci de transmettre noms officiels et photographies aux archives pour mise à jour.
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
