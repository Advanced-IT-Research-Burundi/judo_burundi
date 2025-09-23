<?php

namespace App\Http\Controllers;
use App\Models\Equipe;

use Illuminate\Http\Request;

class AboutController extends Controller
{
public function index()
{
    $equipes = Equipe::all(); // récupérer tous les membres de l'équipe
    return view('pages.about', compact('equipes'));
}
}
