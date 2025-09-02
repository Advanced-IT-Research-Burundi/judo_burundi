<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElementController extends Controller
{
    public function index()
    {
        return view('pages.elements');
    }
}
