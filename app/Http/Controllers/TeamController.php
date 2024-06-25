<?php

namespace App\Http\Controllers;

use App\Models\LevelCategory;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $data = [];
        $data['levelCategories'] = LevelCategory::has('teams')
            ->with(['teams' => function ($query) {
                $query->orderBy('rank');
            }])
            ->get();

        return view('frontend.teams.index', $data);
    }

    public function view(Team $team)
    {
        $data = [];
        $data['team'] = $team;

        return view('frontend.teams.view', $data);
    }
}
