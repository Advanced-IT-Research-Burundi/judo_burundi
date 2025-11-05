<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competition;

class CompetitionsController extends Controller
{
    /**
     * Affiche la liste des compétitions avec filtres et recherche.
     */
    public function index(Request $request)
    {
        // On récupère les valeurs des filtres
        $search = $request->input('search');
        $saison = $request->input('saison');
        $type   = $request->input('type');
        $lieu   = $request->input('lieu');

        // Query de base
        $query = Competition::with(['clubdomicile', 'clubadversaire']);

        // Filtre par nom de compétition
        if ($search) {
            $query->where('nom', 'like', '%' . $search . '%');
        }

        // Filtre par saison
        if ($saison) {
            $query->where('saison', $saison);
        }

        // Filtre par type de compétition
        if ($type) {
            $query->where('type', $type);
        }

        // Filtre par lieu
        if ($lieu) {
            $query->where('lieu', $lieu);
        }

        // Pagination (15 par page)
        $competitions = $query->orderBy('date_competition', 'desc')->paginate(15);

        // Pour les filtres du formulaire
        $saisons = Competition::select('saison')->distinct()->orderBy('saison', 'desc')->pluck('saison');
        $types   = Competition::select('type')->distinct()->pluck('type');
        $lieux   = Competition::select('lieu')->distinct()->pluck('lieu');

        return view('competitions.index', compact('competitions', 'saisons', 'types', 'lieux'));
    }

    public function resultat($id)
    {
        $competition = Competition::findOrFail($id);
        return view('competitions.result', compact('competition'));
    }
}
