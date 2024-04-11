<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use Livewire\Component;
use Livewire\Attributes\On;


class MatchesView extends Component
{
    public $matches = [];
    public $match ;
    public $loser_team_id ;


    public function mount()
    {
        $this->authorize('matches-list');
        $this->matches = Game::with('knockoutRound','homeTeam','awayTeam')->get();

    }

    #[On('chooseWinner')]
    public function chooseWinner($matchId, $winnerId)
    {
        $this->match = Game::with('knockoutRound.tournamentLevelCategory','homeTeam','awayTeam')->find($matchId);

        if ($this->match->home_team_id == $winnerId) {
            $this->loser_team_id = $this->match->away_team_id;
        } elseif ($this->match->away_team_id == $winnerId) {
            $this->loser_team_id = $this->match->home_team_id;
        }

        $this->match->update([
            'winner_team_id' => $winnerId,
            'loser_team_id' => $this->loser_team_id,
            'is_completed' => 1,
        ]);

        $relatedHomeGame = Game::where('related_home_game_id', $this->match->id)->first();
        if ($relatedHomeGame) {
            $relatedHomeGame->update([
                'home_team_id' => $winnerId
            ]);
        }

        $relatedAwayGame = Game::where('related_away_game_id', $this->match->id)->first();
        if ($relatedAwayGame) {
            $relatedAwayGame->update([
                'away_team_id' => $winnerId
            ]);
        }

        $this->redirect(back()->with('success', 'Winner team has been updated successfully!'));
    }

    public function render()
    {
        return view('livewire.matches.matches-index');
    }
}
