<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
{
    public function index()
    {
        $competitions = Competition::with(['clubDomicile', 'clubAdversaire'])
            ->latest('date_competition')
            ->get();

        return view('pages.competitions', compact('competitions'));
    }
}
