<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultatController extends Controller
{
    public function index()
    {
        return view('pages.resultat');
    }
}
