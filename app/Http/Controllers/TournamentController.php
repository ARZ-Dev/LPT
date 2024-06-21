<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\LevelCategory;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TournamentController extends Controller
{
    public function index($levelCategoryId = null)
    {
        $data = [];
        $data['tournaments'] = Tournament::with(['levelCategories'])
            ->when($levelCategoryId, function ($query) use ($levelCategoryId) {
                $query->whereHas('levelCategories', function ($query) use ($levelCategoryId) {
                    $query->where('level_category_id', $levelCategoryId);
                });
            })
            ->orderBy('start_date')
            ->get();
        $data['levelCategories'] = LevelCategory::all();
        $data['levelCategoryId'] = $levelCategoryId;

        return view('frontend.tournaments.index', $data);
    }

    public function getTournaments(Request $request)
    {
        $tournaments = Tournament::when($request->level_category_id != "All Categories", function ($query) use ($request) {
                $query->whereHas('levelCategories', function ($query) use ($request) {
                    $query->where('level_category_id', $request->level_category_id);
                });
            })
            ->when($request->month != "All", function ($query) use ($request) {
                $date = CarbonImmutable::parse($request->year . "-" . $request->month . "-01");
                $query->where(function ($query) use ($date) {
                    $query->whereBetween('start_date', [$date, $date->endOfMonth()])
                        ->orWhereBetween('end_date', [$date, $date->endOfMonth()]);
                });
            })
            ->with(['levelCategories'])
            ->orderBy('start_date')
            ->get();

        if (!count($tournaments)) {
            return response()->json([
                'tournamentsHtml' => '<div class="d-flex justify-content-center"><h6>No tournaments available.</h6></div>',
            ]);
        }

        $tournamentsHtml = "";
        foreach ($tournaments as $tournament) {
            $tournamentsHtml .= View::make('frontend.partials.tournament-card', compact('tournament'))->render();
        }

        return response()->json([
            'tournamentsHtml' => $tournamentsHtml,
        ]);
    }

    public function view($categoryId)
    {
        $data = [];
        $category = TournamentLevelCategory::with(['levelCategory', 'type', 'teams', 'knockoutStages' => ['tournamentDeuceType'], 'groups' => ['groupTeams' => function ($query) {
            $query->orderBy('rank');
        }]])->findOrFail($categoryId);
        $data['category'] = $category;

        $matches = Game::with('knockoutRound','homeTeam','awayTeam', 'startedBy')
            ->whereHas('knockoutRound', function ($query) use ($category) {
                $query->where('tournament_level_category_id', $category->id);
            })
            ->orWhereHas('group', function ($query) use ($category) {
                $query->where('tournament_level_category_id', $category->id);
            })
            ->get();
        $data['matches'] = $matches;

        return view('frontend.tournaments.category-view', $data);
    }
}
