<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Models\GroupTeam;
use App\Models\TournamentLevelCategory;
use Livewire\Component;
use Livewire\Attributes\On;



class MatchesView extends Component
{
    public $matches = [];
    public $match ;
    public $loser_team_id ;
    public $category;

    public function mount($categoryId)
    {
        $this->authorize('matches-list');
        $this->category = TournamentLevelCategory::with('tournament')->findOrFail($categoryId);
        $this->matches = Game::with('knockoutRound','homeTeam','awayTeam')
            ->whereHas('knockoutRound', function ($query) {
                $query->where('tournament_level_category_id', $this->category->id);
            })
            ->orWhereHas('group', function ($query) {
                $query->where('tournament_level_category_id', $this->category->id);
            })
            ->get();
    }

    #[On('chooseWinner')]
    public function chooseWinner($matchId, $winnerId)
    {
        $this->match = Game::with('knockoutRound.tournamentLevelCategory','homeTeam','awayTeam')->findOrFail($matchId);

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

        if ($this->match->type == "Knockouts") {
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
        } else {

            if ($this->match->type == "Group Stages") {
                
                $groupTeamWinner=GroupTeam::where('team_id',$winnerId)->first();
                $groupTeamLooser=GroupTeam::where('team_id',$this->loser_team_id)->first();

                $groupTeamWinner->update([
                    'wins' => $groupTeamWinner->wins + 1 ,
                    'rank' =>($groupTeamWinner->rank > 1) ? ($groupTeamWinner->rank - 1) : $groupTeamWinner->rank,
                ]);

                $groupTeamLooser->update([
                    'losses' =>  $groupTeamLooser->losses + 1  ,
                    'rank' =>$groupTeamLooser->rank  + 1 ,
                ]);
                
            }
        }

        return to_route('matches', $this->category->id)->with('success', 'Winner team has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.matches.matches-index');
    }
}
