<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipe;

class DirectionController extends Controller
{
     public function index()
    {
        // Récupère tous les membres de la direction
        $equipes = Equipe::all();
        return view('pages.direction', compact('equipes'));
    }
}
