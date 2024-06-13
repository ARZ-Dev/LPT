<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\LevelCategory;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        $data = [];
        $data['levelCategories'] = LevelCategory::all();

        $data['matches'] = Game::whereBetween('datetime', [now()->startOfMonth(), now()->endOfMonth()])
            ->with(['homeTeam', 'awayTeam', 'knockoutRound' => ['tournamentLevelCategory.levelCategory'], 'group' => ['tournamentLevelCategory.levelCategory'], 'relatedHomeGame', 'relatedAwayGame'])
            ->get();

        return view('frontend.matches.index', $data);
    }

    public function getMatches(Request $request)
    {
        $matches = Game::when($request->category_id != "All Categories", function ($query) use ($request) {
                $query->where('level_category_id', $request->level_category_id);
            })
            ->when($request->month != "All", function ($query) use ($request) {
                $date = CarbonImmutable::parse($request->year . "-" . $request->month . "-01");
                $query->whereBetween('datetime', [$date, $date->endOfMonth()]);
            })
            ->with(['homeTeam', 'awayTeam', 'knockoutRound' => ['tournamentLevelCategory.levelCategory'], 'group' => ['tournamentLevelCategory.levelCategory'], 'relatedHomeGame', 'relatedAwayGame'])
            ->get();

        $matchesHtml = "";
        if (!count($matches)) {
            return response()->json([
                'matchesHtml' => '<div class="d-flex justify-content-center"><h6>No matches available.</h6></div>',
            ]);
        }

        foreach ($matches as $match) {
            $time = $match->datetime ? Carbon::parse($match->datetime)->format('H:i') : "N/A";
            $day = $match->datetime ? Carbon::parse($match->datetime)->format('D j') : "N/A";
            $month = $match->datetime ? Carbon::parse($match->datetime)->format('M Y') : "N/A";

            $homeTeamName = $match->homeTeam ? $match->homeTeam->nickname : ($match->relatedHomeGame ? 'Winner of ' . ($match->relatedHomeGame->knockoutRound?->name ?? '') : '');
            $awayTeamName = $match->awayTeam ? $match->awayTeam->nickname : ($match->relatedAwayGame ? 'Winner of ' . ($match->relatedAwayGame->knockoutRound?->name ?? '') : '');

            $matchCategory = getMatchCategory($match)->name ?? '';
            $matchRound = getMatchRound($match) ?? '';

            $matchesHtml .= '
                <article class="game-result">
                    <div class="game-info">
                        <p class="game-info-subtitle">
                            Time: <time>' . $time . '</time>
                        </p>
                        <h3 class="game-info-title">' . $matchCategory . ' - ' . $matchRound . '</h3>
                        <div class="game-info-main">
                            <div class="game-info-team game-info-team-first">
                                <div class="game-result-team-name">' . $homeTeamName . '</div>
                                <div class="game-result-team-country">Home</div>
                            </div>
                            <div class="game-info-middle game-info-middle-vertical">
                                <time class="time-big">
                                    <span class="heading-3">' . $day . '</span> ' . $month . '
                                </time>
                                <div class="game-result-divider-wrap"><span class="game-info-team-divider">VS</span></div>
                                <div class="group-sm">
                                    <div class="button button-sm button-share-outline">Share
                                        <ul class="game-info-share">
                                            <li class="game-info-share-item"><a class="icon fa fa-facebook" href="#"></a></li>
                                            <li class="game-info-share-item"><a class="icon fa fa-twitter" href="#"></a></li>
                                            <li class="game-info-share-item"><a class="icon fa fa-google-plus" href="#"></a></li>
                                            <li class="game-info-share-item"><a class="icon fa fa-instagram" href="#"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="game-info-team game-info-team-second">
                                <div class="game-result-team-name">' . $awayTeamName . '</div>
                                <div class="game-result-team-country">Away</div>
                            </div>
                        </div>
                    </div>
                </article>
            ';
        }

        return response()->json([
            'matchesHtml' => $matchesHtml,
        ]);
    }
}
