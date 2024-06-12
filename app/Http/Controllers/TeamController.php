<?php

namespace App\Http\Controllers;

use App\Models\LevelCategory;
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
}
