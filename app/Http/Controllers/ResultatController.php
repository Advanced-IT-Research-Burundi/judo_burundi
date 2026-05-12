<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultatController extends Controller
{
    /**
     * Alias historique / menu : redirige vers la liste compétitions & résultats.
     */
    public function index(Request $request)
    {
        return redirect()->route('competitions.index', $request->query());
    }
}
