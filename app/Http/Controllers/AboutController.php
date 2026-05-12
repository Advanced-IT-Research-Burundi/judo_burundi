<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        /* Périodes à compléter avec les archives officielles de la fédération */
        $presidents = [
            ['de' => '1975', 'a' => '1982', 'nom' => null, 'photo' => null],
            ['de' => '1983', 'a' => '1991', 'nom' => null, 'photo' => null],
            ['de' => '1992', 'a' => '2004', 'nom' => null, 'photo' => null],
            ['de' => '2005', 'a' => '2015', 'nom' => null, 'photo' => null],
            ['de' => '2016', 'a' => 'présent', 'nom' => null, 'photo' => null],
        ];

        return view('pages.about', compact('presidents'));
    }
}
