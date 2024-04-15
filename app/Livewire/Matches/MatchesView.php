<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\TournamentLevelCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;



class MatchesView extends Component
{
    public $matches = [];
    public $match ;
    public $loser_team_id ;
    public $category;
    public $tournament;

    public function mount($categoryId)
    {
        $this->authorize('matches-list');
        $this->category = TournamentLevelCategory::with('tournament.levelCategories')->findOrFail($categoryId);
        $this->tournament = $this->category->tournament;
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
        DB::beginTransaction();
        try {
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

                $this->match->knockoutRound->update([
                    'is_completed' => true,
                ]);

                if ($this->match->knockoutRound->name == "Final") {
                    $this->category->update([
                        'is_completed' => true,
                        'winner_team_id' => $winnerId,
                        'silver_team_id' => $this->loser_team_id,
                    ]);

                    $completedCategoriesCount = $this->tournament->levelCategories()->where('is_completed', true)->count();
                    if ( count($this->tournament->levelCategories) == $completedCategoriesCount ) {
                        $this->tournament->update([
                            'is_completed' => true,
                        ]);
                    }
                }

            } else {

                $teams = GroupTeam::where('group_id', $this->match->group_id)->orderBy('wins', 'desc')->orderBy('id', 'asc')->get();

                $groupTeamWinner=GroupTeam::where('team_id',$winnerId)->where('group_id',$this->match->group_id)->first();
                $groupTeamLooser=GroupTeam::where('team_id',$this->loser_team_id)->where('group_id',$this->match->group_id)->first();

                $groupTeamWinner->increment('wins');
                $groupTeamWinner->increment('matches_played');
                $groupTeamLooser->increment('losses');
                $groupTeamLooser->increment('matches_played');

                foreach ($teams as $index => $team) {
                    $newRank = $index + 1;
                    $team->update(['rank' => $newRank]);
                }

                $matchesPlayedCount = GroupTeam::where('group_id', $this->match->group_id)->where('matches_played', count($teams) - 1)->count();

                $group = Group::where('id',$this->match->group_id)->first();

                $groupsCount = Group::where('tournament_level_category_id',$this->category->id)->count();

                $smallestRanks = $teams->sortBy('rank')->take($this->category->number_of_winners_per_group);

                if ($matchesPlayedCount == count($teams)) {
                    $group->update(['is_completed' => 1,]);

                    foreach ($smallestRanks as $team) {
                        $team->update(['has_qualified' => 1]);
                    }

                }

                $groupsIsCompleted = Group::where('tournament_level_category_id',$this->category->id)->where('is_completed',1)->count();
                if($groupsIsCompleted == $groupsCount){
                    $this->category->update(['is_group_stages_completed' => 1,]);
                }
            }

            DB::commit();

            return to_route('matches', $this->category->id)->with('success', 'Winner team has been updated successfully!');

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
        return view('livewire.matches.matches-index');
    }
}
