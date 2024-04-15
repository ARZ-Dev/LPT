<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Models\Group;
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

                $teams = GroupTeam::where('group_id', $this->match->group_id)->orderBy('wins', 'desc')->orderBy('id', 'asc')->get();
                $matchesPlayed = GroupTeam::where('group_id', $this->match->group_id)->where('matches_played',count($teams) - 1)->get();
                $group =Group::where('id',$this->match->group_id)->first();
                $tournamentLevelCategories=TournamentLevelCategory::where('id',$this->category->id)->first();
      

                $groupTeamWinner=GroupTeam::where('team_id',$winnerId)->where('group_id',$this->match->group_id)->first();
                $groupTeamLooser=GroupTeam::where('team_id',$this->loser_team_id)->where('group_id',$this->match->group_id)->first();

                $groupTeamWinner->increment('wins');
                $groupTeamWinner->increment('matches_played');
                $groupTeamLooser->increment('losses');
                $groupTeamLooser->increment('matches_played');

  
                $teams = GroupTeam::where('group_id', $this->match->group_id)->orderBy('wins', 'desc')->orderBy('id', 'asc')->get();
            
                foreach ($teams as $index => $team) {
                    $newRank = $index + 1;
                    $team->update(['rank' => $newRank]);
                }

                $matchesPlayed = GroupTeam::where('group_id', $this->match->group_id)->where('matches_played',count($teams) - 1)->get();

                
                if(count($matchesPlayed) == count($teams)  ){

                    $group->update(['is_completed' => 1,]);
                    $tournamentLevelCategories->update(['is_group_stages_completed' => 1,]);

                }
               
        }

            return to_route('matches', $this->category->id)->with('success', 'Winner team has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.matches.matches-index');
    }
}
