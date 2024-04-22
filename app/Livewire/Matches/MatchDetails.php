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
        dd($this->points->toArray());
    }

    public function render()
    {
        return view('livewire.matches.match-details');
    }
}
