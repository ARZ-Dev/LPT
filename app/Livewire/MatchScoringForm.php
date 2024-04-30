<?php

namespace App\Livewire;

use App\Livewire\Matches\MatchesView;
use App\Models\Game;
use App\Models\Set;
use App\Models\SetGamePoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;

class MatchScoringForm extends Component
{
    public $homeTeam;
    public $awayTeam;
    public $startedAt;
    public $referee;
    public $matchId;
    public $servingTeamId;
    public bool $isAlreadyStarted = false;
    public $nbOfSetsToWin;
    public $nbOfGamesToWin;
    public $deuceType;
    public $tiebreak = false;
    public $tiebreakPointsToWin;
    public $category;
    public $stage;

    public function mount($matchId)
    {
        $this->matchId = $matchId;
        $match = Game::with(['homeTeam', 'awayTeam', 'knockoutRound', 'knockoutRound.knockoutStage', 'group', 'group.knockoutStage', 'sets' => [
                    'setGames' => [
                        'points'
                    ]
                ]
            ])->findOrFail($matchId);

        $this->category = $match->type == "Knockouts" ? $match->knockoutRound?->tournamentLevelCategory : $match->group?->tournamentLevelCategory;

        $this->isAlreadyStarted = $match->is_started;

        $this->homeTeam = $match->homeTeam;
        $this->awayTeam = $match->awayTeam;
        $this->startedAt = $match->started_at ?? now()->format('d-m-Y H:i');
        $this->referee = auth()->user()->full_name;

        if ($match->type == "Knockouts") {
            $this->stage = $match->knockoutRound?->knockoutStage;
        } else {
            $this->stage = $match->group?->knockoutStage;
        }

        $this->nbOfSetsToWin = $this->stage->nb_of_sets;
        $this->nbOfGamesToWin = $this->stage->nb_of_games;
        $this->tiebreakPointsToWin = $this->stage->tie_break;
        $this->deuceType = $this->stage->tournamentDeuceType;

        $latestSet = $match->sets()->latest()->where('is_completed', false)->first();
        if ($latestSet) {
            $this->tiebreak = $latestSet->home_team_score == $latestSet->away_team_score && $latestSet->home_team_score == $this->nbOfGamesToWin;
        }
    }

    public function rules()
    {
        return [
            'servingTeamId' => [new RequiredIf(!$this->isAlreadyStarted)]
        ];
    }

    public function scorePoint($teamId)
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $match = Game::with(['homeTeam', 'awayTeam', 'sets' => ['setGames']])->findOrFail($this->matchId);
            throw_if($match->is_completed, new \Exception("Match is already completed!"));

            $stageName = $this->stage->name;
            $settingsLink = route('knockoutStage.view', $this->category->id);

            throw_if(!$this->nbOfSetsToWin || !$this->nbOfGamesToWin || !$this->tiebreakPointsToWin || !$this->deuceType,
                new \Exception($stageName . " scoring settings are required, please go to <a href='$settingsLink'>this link</a> to add them!"));

            $match->loadMissing('sets');
            $team = $teamId == $this->homeTeam->id ? $this->homeTeam : $this->awayTeam;

            if (!$match->is_started) {
                $this->isAlreadyStarted = true;
                $match->update([
                    'is_started' => true,
                    'started_at' => now(),
                    'started_by' => auth()->id(),
                ]);
            }

            $pendingSet = $match->sets()->latest('set_number')->where('is_completed', false)->first();

            if (!$pendingSet) {
                $lastPlayedSet = $match->sets()->where('is_completed', true)->latest('id')->first();

                // Create a new set if no set exists
                $pendingSet = $match->sets()->create([
                    'set_number' => ($lastPlayedSet?->set_number ?? 0) + 1,
                    'home_team_score' => 0,
                    'away_team_score' => 0,
                ]);
            }

            $pendingSetGame = $pendingSet->setGames()->latest('game_number')->where('is_completed', false)->first();

            if (!$pendingSetGame) {

                $servingTeamId = $this->servingTeamId;
                if (!$servingTeamId) {
                    $lastMatchSet = $match->setGames()->where('set_games.is_completed', true)->latest('id')->first();
                    $servingTeamId = $lastMatchSet?->serving_team_id == $this->homeTeam->id ? $this->awayTeam->id : $this->homeTeam->id;
                }

                $lastPlayedSetGame = $pendingSet->setGames()->where('is_completed', true)->latest('game_number')->first();

                // Create a new set game if no set game exists
                $pendingSetGame = $pendingSet->setGames()->create([
                    'serving_team_id' => $servingTeamId,
                    'game_number' => ($lastPlayedSetGame?->game_number ?? 0) + 1,
                    'home_team_score' => 0,
                    'away_team_score' => 0,
                ]);
                $this->servingTeamId = null;
            }

            // Get the scores for the teams
            $homeTeamScore = $pendingSetGame->home_team_score;
            $awayTeamScore = $pendingSetGame->away_team_score;

            // Determine which team is scoring
            if ($teamId == $this->homeTeam->id) {
                // Update the score for home team
                $scores = $this->getNextScore($homeTeamScore, $awayTeamScore, $pendingSetGame);
                $homeTeamScore = $scores['first_team'];
                $awayTeamScore = $scores['second_team'];
            } else {
                // Update the score for away team
                $scores = $this->getNextScore($awayTeamScore, $homeTeamScore, $pendingSetGame);
                $awayTeamScore = $scores['first_team'];
                $homeTeamScore = $scores['second_team'];
            }

            $latestPoint = SetGamePoint::where('set_game_id', $pendingSetGame->id)->latest('id')->first();
            SetGamePoint::create([
                'set_game_id' => $pendingSetGame->id,
                'point_number' => ($latestPoint->point_number ?? 0) + 1,
                'point_team_id' => $teamId,
                'home_team_score' => $homeTeamScore,
                'away_team_score' => $awayTeamScore,
            ]);

            // Check if the set is won
            if ($this->isSetGameWon($homeTeamScore, $awayTeamScore)) {
                // Handle set win
                $this->handleSetGameWin($pendingSetGame, $team, $homeTeamScore, $awayTeamScore);
            } else {
                $pendingSetGame->update([
                    'home_team_score' => $homeTeamScore,
                    'away_team_score' => $awayTeamScore,
                ]);
            }


            DB::commit();

        } catch (\Exception $exception) {

            DB::rollBack();

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Get the next score for a team based on the current score and opponent's score.
     */
    protected function getNextScore($currentScore, $opponentScore, $pendingSetGame)
    {
        if (!$this->tiebreak) {
            // Define the scoring progression
            $scoreProgression = [
                0 => 15,
                15 => 30,
                30 => 40,
                40 => 'won',
                "AD" => 'won'
            ];

            if ($this->deuceType->name != "Short Deuce") {

                if ($currentScore == 40 && $opponentScore == 40) {

                    if ($this->deuceType->name == "1 Deuce") {
                        $deuce = SetGamePoint::where('set_game_id', $pendingSetGame->id)
                            ->where(function ($query) {
                                $query->where('home_team_score', 'AD')
                                    ->orWhere('away_team_score', 'AD');
                            })
                            ->count();

                        if ($deuce) {
                            return [
                                'first_team' => 'won',
                                'second_team' => $opponentScore,
                            ];
                        }
                    }

                    return [
                        'first_team' => "AD",
                        'second_team' => $opponentScore,
                    ];
                }

                if ($currentScore == 40 && $opponentScore == "AD") {
                    return [
                        'first_team' => 40,
                        'second_team' => 40,
                    ];
                }
            }

            // Return the next score based on the progression
            return [
                'first_team' => $scoreProgression[$currentScore],
                'second_team' => $opponentScore,
            ];
        } else {

            $nextScore = $currentScore + 1;
            if ($nextScore === $this->tiebreakPointsToWin && $opponentScore < $this->tiebreakPointsToWin - 1) {
                $this->tiebreak = false;

                return [
                    'first_team' => 'won',
                    'second_team' => $opponentScore,
                ];
            }

            if ($currentScore > $this->tiebreakPointsToWin - 2 && $opponentScore > $this->tiebreakPointsToWin - 2 && $nextScore == $opponentScore + 2) {
                $this->tiebreak = false;

                return [
                    'first_team' => 'won',
                    'second_team' => $opponentScore,
                ];
            }

            return [
                'first_team' => $nextScore,
                'second_team' => $opponentScore,
            ];
        }
    }

    /**
     * Check if the set is won by either team.
     */
    protected function isSetGameWon($homeTeamScore, $awayTeamScore)
    {
        return $homeTeamScore === 'won' || $awayTeamScore === 'won';
    }

    /**
     * Handle a set game win.
     */
    protected function handleSetGameWin($pendingSetGame, $winningTeam, $homeTeamScore, $awayTeamScore)
    {
        // Update the scores and set the set as won
        $pendingSetGame->update([
            'home_team_score' => $homeTeamScore,
            'away_team_score' => $awayTeamScore,
            'is_completed' => true,
            'completed_at' => now(),
            'winner_team_id' => $winningTeam->id,
        ]);

        if ($winningTeam->id == $this->homeTeam->id) {
            $pendingSetGame->set->increment('home_team_score');
        } else {
            $pendingSetGame->set->increment('away_team_score');
        }

        if ($pendingSetGame->set->home_team_score == $this->nbOfGamesToWin && $pendingSetGame->set->away_team_score == $this->nbOfGamesToWin) {
            $this->tiebreak = true;
        }

        $this->checkSetResults($pendingSetGame, $winningTeam);
    }

    public function checkSetResults($pendingSetGame, $winningTeam)
    {
        $hasHomeTeamWon = ($pendingSetGame->set->home_team_score == $this->nbOfGamesToWin && $pendingSetGame->set->away_team_score < $this->nbOfGamesToWin - 1)
            || $pendingSetGame->set->away_team_score === $this->nbOfGamesToWin + 1;
        $hasAwayTeamWon = ($pendingSetGame->set->away_team_score == $this->nbOfGamesToWin && $pendingSetGame->set->home_team_score < $this->nbOfGamesToWin - 1)
            || $pendingSetGame->set->home_team_score === $this->nbOfGamesToWin + 1;

        if ($hasHomeTeamWon || $hasAwayTeamWon) {
            $pendingSetGame->set->update([
                'winner_team_id' => $winningTeam->id,
                'is_completed' => true,
                'completed_at' => now(),
            ]);

            $winningSetsCount = Set::where('game_id', $pendingSetGame->set->game_id)->where('winner_team_id', $winningTeam->id)->count();
            if ($winningSetsCount === $this->nbOfSetsToWin) {
                MatchesView::updateMatchWinner($pendingSetGame->set->game_id, $winningTeam->id);

                return $this->dispatch('swal:success', [
                    'title' => 'Great!',
                    'text'  => $winningTeam->nickname . " has won!",
                ]);
            }
        }
    }

    public function render()
    {
        $data = [];

        $match = Game::with(['homeTeam', 'awayTeam', 'sets' => ['setGames'], 'setGames'])->findOrFail($this->matchId);
        $data['match'] = $match;

        $currentSetGame = $match->setGames()->latest('id')->where('set_games.is_completed', true)->first();
        if ($currentSetGame) {
            $this->servingTeamId = $currentSetGame?->serving_team_id == $this->homeTeam->id ? $this->awayTeam->id : $this->homeTeam->id;
        } else {
            $lastSetGame = $match->setGames()->latest('id')->where('set_games.is_completed', false)->first();
            $this->servingTeamId = $lastSetGame?->serving_team_id;
        }

        return view('livewire.match-scoring-form', $data);
    }
}
