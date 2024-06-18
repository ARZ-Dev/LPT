<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $data = [];
        $data['upcomingMatches'] = Game::where('is_started', false)->where('datetime', '>', now())->orderBy('datetime')->with(['homeTeam', 'awayTeam'])->get();

        return view('frontend.home.home', $data);
    }
}
