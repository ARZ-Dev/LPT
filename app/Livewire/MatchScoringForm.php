<?php

namespace App\Livewire;

use App\Models\Game;
use App\Models\Set;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MatchScoringForm extends Component
{
    public $homeTeam;
    public $awayTeam;
    public $match;
    public $startedAt;
    public $referee;

    public function mount($matchId)
    {
        $this->match = Game::with(['homeTeam', 'awayTeam', 'sets' => [
                    'setGames'
                ]
            ])->findOrFail($matchId);

        $this->homeTeam = $this->match->homeTeam;
        $this->awayTeam = $this->match->awayTeam;
        $this->startedAt = $this->match->started_at ?? now()->format('d-m-Y H:i');
        $this->referee = auth()->user()->full_name;
    }

    public function scorePoint($teamId)
    {
        DB::beginTransaction();
        try {
            $this->match->loadMissing('sets');
            $team = $teamId == $this->homeTeam->id ? $this->homeTeam : $this->awayTeam;

            $latestSet = $this->match->sets()->latest('set_number')->where('is_completed', false)->first();

            if (!$latestSet) {
                // Create a new set if no set exists
                $latestSet = $this->match->sets()->create([
                    'set_number' => 1,
                    'home_team_score' => 0,
                    'away_team_score' => 0,
                ]);
            }

            $latestSetGame = $latestSet->setGames()->latest('game_number')->where('is_completed', false)->first();

            if (!$latestSetGame) {
                // Create a new set game if no set game exists
                $latestSetGame = $latestSet->setGames()->create([
                    'game_number' => 1,
                    'home_team_score' => 0,
                    'away_team_score' => 0,
                ]);
            }


            // Get the scores for the teams
            $homeTeamScore = $latestSetGame->home_team_score;
            $awayTeamScore = $latestSetGame->away_team_score;

            // Determine which team is scoring
            if ($teamId == $this->homeTeam->id) {
                // Update the score for home team
                $scores = $this->getNextScore($homeTeamScore, $awayTeamScore);
                $homeTeamScore = $scores['first_team'];
                $awayTeamScore = $scores['second_team'];
            } else {
                // Update the score for away team
                $scores = $this->getNextScore($awayTeamScore, $homeTeamScore);
                $awayTeamScore = $scores['first_team'];
                $homeTeamScore = $scores['second_team'];
            }

            // Check if the set is won
            if ($this->isSetGameWon($homeTeamScore, $awayTeamScore)) {
                // Handle set win
                $this->handleSetGameWin($latestSetGame, $team, $homeTeamScore, $awayTeamScore);
            } else {
                $latestSetGame->update([
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
    protected function getNextScore($currentScore, $opponentScore)
    {
        // Define the scoring progression
        $scoreProgression = [
            0 => 15,
            15 => 30,
            30 => 40,
            40 => 'won',
            "AD" => 'won'
        ];

        // Check if the current score is 40 and opponent's score is also 40
        if ($currentScore == 40 && $opponentScore == 40) {
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

        // Return the next score based on the progression
        return [
            'first_team' => $scoreProgression[$currentScore],
            'second_team' => $opponentScore,
        ];
    }

    /**
     * Check if the set is won by either team.
     */
    protected function isSetGameWon($homeTeamScore, $awayTeamScore)
    {
        return $homeTeamScore === 'won' || $awayTeamScore === 'won';
    }

    /**
     * Handle a set win.
     */
    protected function handleSetGameWin($latestSetGame, $winningTeam, $homeTeamScore, $awayTeamScore)
    {
        // Update the scores and set the set as won
        if ($homeTeamScore === 'won') {
            $latestSetGame->update([
                'is_completed' => true,
                'winner_team_id' => $winningTeam->id,
            ]);

            $latestSetGame->set->increment('home_team_score');

        } else {
            $latestSetGame->update([
                'is_completed' => true,
                'winner_team_id' => $winningTeam->id,
            ]);

            $latestSetGame->set->increment('away_team_score');
        }
    }

    public function render()
    {
        return view('livewire.match-scoring-form');
    }
}
