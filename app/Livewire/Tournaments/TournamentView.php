<?php

namespace App\Livewire\Tournaments;

use App\Models\Game;
use App\Models\Group;
use App\Models\KnockoutRound;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentView extends Component
{
    public $tournaments = [];


    public function mount()
    {
        $this->authorize('tournament-list');
        $this->tournaments = Tournament::all();
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('tournament-delete');

        $tournament = Tournament::with('levelCategories')->findOrFail($id);

        $tournament->levelCategories->each->delete();

        $tournament->delete();

        return to_route('tournaments')->with('success', 'Tournament has been deleted successfully!');
    }

    #[On('knockoutRound')]
    public function knockoutRound($id)
    {
        $winnerTeamsIds = Game::with(['knockoutRound.tournamentLevelCategory' => function ($query) use ($id) {
            $query->where('tournament_id', $id);
        }])->where('is_completed', 1)->pluck('winner_team_id')->ToArray();

        $winnerTeamsCount = count($winnerTeamsIds) /2;

        $game = Game::with(['knockoutRound.tournamentLevelCategory' => function ($query) use ($id) {
            $query->where('tournament_id', $id);
        }])->where('is_completed', 1)->first();


        $knockout_round_id = $game->knockout_round_id;

        for($i=0; $i <= $winnerTeamsCount; $i = $i +2) {
            $team1_id = $winnerTeamsIds[$i];
            $team2_id = $winnerTeamsIds[$i + 1];

            Game::create([
                'type'=>"knockouts",
                'knockout_round_id'=>$knockout_round_id + 1,
                'home_team_id'=>$team1_id,
                'away_team_id'=>$team2_id,
            ]);
        }


    }

    public function render()
    {
        return view('livewire.tournaments.tournament-index');
    }
}
