<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MatchSetScore extends Component
{
    public $homeTeam;
    public $awayTeam;
    public $startedAt;
    public $referee;
    public $matchId;
    public $match;
    public $category;
    public $nbOfSetsToWin;
    public $nbOfGamesToWin;
    public $maxSetsCount;
    public $deuceType;
    public $tiebreakPointsToWin;
    public $stage;
    public $sets = [];

    public function mount($matchId)
    {
        $this->match = Game::with(['homeTeam', 'awayTeam'])->findOrFail($matchId);
        $this->homeTeam = $this->match->homeTeam;
        $this->awayTeam = $this->match->awayTeam;
        $this->category = $this->match->tournamentLevelCategory;
        $this->startedAt = $match->started_at ?? now()->format('d-m-Y H:i');
        $this->referee = $match->startedBy?->full_name ?? auth()->user()->full_name;

        if ($this->match->type == "Knockouts") {
            $this->stage = $this->match->knockoutRound?->knockoutStage;
        } else {
            $this->stage = $this->match->group?->knockoutStage;
        }

        $this->nbOfGamesToWin = $this->stage->nb_of_games;
        $this->tiebreakPointsToWin = $this->stage->tie_break;
        $this->deuceType = $this->stage->tournamentDeuceType;

        $this->nbOfSetsToWin = $this->stage->nb_of_sets;
        $this->maxSetsCount = ($this->nbOfSetsToWin - 1) * 2;
        for ($i = 0; $i < $this->nbOfSetsToWin; $i++) {
            $this->sets[] = [
                'home_team_score' => '',
                'away_team_score' => '',
            ];
        }
    }

    public function addSet()
    {
        $this->sets[] = [
            'home_team_score' => '',
            'away_team_score' => '',
        ];
    }

    public function removeSet($key)
    {
        unset($this->sets[$key]);
    }

    public function rules()
    {
        return [
            'sets.*.home_team_score' => ['required', 'integer', 'min:0', 'max:7'],
            'sets.*.away_team_score' => ['required', 'integer', 'min:0', 'max:7'],
        ];
    }

    public function submit()
    {
        $this->validate();

        DB::beginTransaction();
        try {

            $homeWins = 0;
            $awayWins = 0;

            foreach ($this->sets as $key => $set) {
                $homeScore = (int) $set['home_team_score'];
                $awayScore = (int) $set['away_team_score'];

                // Validate that the set score is either 6 or 7 (tiebreak scenario)
                if (!($homeScore == $this->nbOfGamesToWin || $homeScore == ($this->nbOfGamesToWin + 1)) && !($awayScore == $this->nbOfGamesToWin || $awayScore == ($this->nbOfGamesToWin + 1))) {
                    return throw new \Exception( 'Set '. $key + 1 .' must have a winning score of '. $this->nbOfGamesToWin .' or '. $this->nbOfGamesToWin + 1 .' games.');
                }

                // Check that the winner wins by at least 2 games if no tiebreak
                if ($homeScore >= ($this->nbOfGamesToWin - 1) && $awayScore >= ($this->nbOfGamesToWin - 1)) {
                    if ($homeScore != ($this->nbOfGamesToWin + 1) && $awayScore != ($this->nbOfGamesToWin + 1) ) {
                        return throw new \Exception( 'Set '. $key + 1 .' tiebreak winner must have a winning score of '. $this->nbOfGamesToWin + 1 .' games.');
                    }
                }

                // Count the number of sets won by each player
                if ($homeScore > $awayScore) {
                    $homeWins++;
                } elseif ($awayScore > $homeScore) {
                    $awayWins++;
                }

                throw_if(($homeWins !== $this->nbOfSetsToWin) && ($awayWins !== $this->nbOfSetsToWin), 'The winner must win ' . $this->nbOfSetsToWin . ' sets to end the match.');
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

    public function render()
    {
        return view('livewire.matches.match-set-score');
    }
}
