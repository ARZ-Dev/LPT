<?php

namespace App\Livewire\Tournaments;

use App\Models\Game;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentCategoryView extends Component
{
    public $tournamentCategories = [];
    public $tournament;

    public function mount($tournamentId)
    {
        $this->tournament = Tournament::findOrFail($tournamentId);
        $this->tournamentCategories = TournamentLevelCategory::where('tournament_id', $tournamentId)
            ->with(['levelCategory', 'type'])
            ->get();
    }

    #[On('delete')]
    public function delete($id)
    {
        $tournamentCategory = TournamentLevelCategory::with('teams')->find($id);

        $tournamentCategory->teams?->each->delete();

        $tournamentCategory->delete();

        return to_route('tournaments-categories', $this->tournament->id)->with('success', 'Tournament category has been deleted successfully!');
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
        return view('livewire.tournaments.tournament-category-view');
    }
}
