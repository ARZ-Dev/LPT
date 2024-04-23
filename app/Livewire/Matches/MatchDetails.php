<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Models\SetGamePoint;
use App\Models\TournamentLevelCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class MatchDetails extends Component
{
    public $match;
    public $points;

    public $category;

    public function mount($matchId)
    {
        $this->match = Game::with('homeTeam','awayTeam','knockoutRound.tournamentLevelCategory')->findOrFail($matchId);
        $setGamesIds = $this->match->setGames()->pluck('set_games.id')->toArray();
        $this->points = SetGamePoint::whereIn('set_game_id', $setGamesIds)->get();
        $this->category = $this->match->type == "Knockouts" ? $this->match->knockoutRound?->tournamentLevelCategory : $this->match->group?->tournamentLevelCategory;
    }

    public function render()
    {
        return view('livewire.matches.match-details');
    }
}
