<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\LevelCategory;
use App\Models\SetGamePoint;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class MatchController extends Controller
{
    public function index()
    {
        $data = [];
        $data['levelCategories'] = LevelCategory::all();

        $data['matches'] = Game::whereBetween('datetime', [now()->startOfMonth(), now()->endOfMonth()])
            ->with(['homeTeam', 'awayTeam', 'knockoutRound' => ['tournamentLevelCategory' => ['levelCategory', 'tournament']], 'group' => ['tournamentLevelCategory' => ['levelCategory', 'tournament']], 'relatedHomeGame', 'relatedAwayGame', 'sets'])
            ->get();

        return view('frontend.matches.index', $data);
    }

    public function getMatches(Request $request)
    {
        $matches = Game::when($request->level_category_id != "All Categories", function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->whereHas('group', function ($query) use ($request) {
                        $query->whereHas('tournamentLevelCategory', function ($query) use ($request) {
                            $query->where('level_category_id', $request->level_category_id);
                        });
                    })
                    ->orWhereHas('knockoutRound', function ($query) use ($request) {
                        $query->whereHas('tournamentLevelCategory', function ($query) use ($request) {
                            $query->where('level_category_id', $request->level_category_id);
                        });
                    });
                });
            })
            ->when($request->month != "All", function ($query) use ($request) {
                $date = CarbonImmutable::parse($request->year . "-" . $request->month . "-01");
                $query->whereBetween('datetime', [$date, $date->endOfMonth()]);
            })
            ->with(['homeTeam', 'awayTeam', 'knockoutRound' => ['tournamentLevelCategory' => ['levelCategory', 'tournament']], 'group' => ['tournamentLevelCategory' => ['levelCategory', 'tournament']], 'relatedHomeGame', 'relatedAwayGame', 'sets'])
            ->orderByRaw("
                CASE
                    WHEN status = 'started' THEN 1
                    ELSE 0
                END DESC, datetime DESC")
            ->get();

        $matchesHtml = "";
        if (!count($matches)) {
            return response()->json([
                'matchesHtml' => '<div class="d-flex justify-content-center"><h6>No matches available.</h6></div>',
            ]);
        }

        foreach ($matches as $match) {
            $matchesHtml .= View::make('frontend.partials.match-card', compact('match'))->render();
        }

        return response()->json([
            'matchesHtml' => $matchesHtml,
        ]);
    }

    public function view($matchId)
    {
        $match = Game::with(['sets' => ['setGames', 'points' => ['pointTeam']]])->findOrFail($matchId);
        $points = $match->sets->pluck('points')->flatten();

        return view('frontend.matches.view', compact('match', 'points'));
    }
}
