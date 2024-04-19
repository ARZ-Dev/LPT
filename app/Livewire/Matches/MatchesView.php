<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\KnockoutRound;
use App\Models\Team;
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
    public $datetimeModel ;
    public $wael ;


    public function mount($categoryId)
    {
        $this->authorize('matches-list');
        $this->category = TournamentLevelCategory::with('tournament.levelCategories', 'type')->findOrFail($categoryId);
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
            $this->match = Game::with('homeTeam','awayTeam')->findOrFail($matchId);

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

            $this->match->homeTeam->increment('matches');
            $this->match->awayTeam->increment('matches');
            $this->match->winnerTeam->increment('wins');
            $this->match->loserTeam->increment('losses');

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

                $knockoutStage = $this->match->knockoutRound->knockoutStage;
                $completedRoundsCount = KnockoutRound::where('knockout_stage_id', $knockoutStage->id)->where('is_completed', true)->count();
                if ($completedRoundsCount == $knockoutStage->knockoutRounds()->count()) {
                    $knockoutStage->update([
                        'is_completed' => true,
                    ]);
                }

                if ($this->match->knockoutRound->name == "Final") {
                    $this->category->update([
                        'is_completed' => true,
                        'winner_team_id' => $winnerId,
                        'silver_team_id' => $this->loser_team_id,
                    ]);

                    $this->match->winnerTeam->increment('points', $this->category->type->points);

                    $this->updateTeamsRank($this->category->level_category_id);

                    $completedCategoriesCount = $this->tournament->levelCategories()->where('is_completed', true)->count();
                    if ( count($this->tournament->levelCategories) == $completedCategoriesCount ) {
                        $this->tournament->update([
                            'is_completed' => true,
                        ]);
                    }
                }

            } else {
                $group = Group::findOrFail($this->match->group_id);
                $groupTeams = GroupTeam::where('group_id', $this->match->group_id)->orderBy('wins', 'desc')->get();

                $groupTeamWinner = GroupTeam::where('team_id',$winnerId)->where('group_id',$this->match->group_id)->first();
                $groupTeamLoser = GroupTeam::where('team_id',$this->loser_team_id)->where('group_id',$this->match->group_id)->first();

                $groupTeamWinner->increment('wins');
                $groupTeamWinner->increment('matches_played');
                $groupTeamLoser->increment('losses');
                $groupTeamLoser->increment('matches_played');

                $groupTeams->each(function ($team, $index) {
                    $team->update(['rank' => $index + 1]);
                });

                $matchesPlayedCount = GroupTeam::where('group_id', $this->match->group_id)->where('matches_played', $groupTeams->count() - 1)->count();

                if ($matchesPlayedCount == $groupTeams->count()) {

                    $group->update(['is_completed' => true]);

                    GroupTeam::where('group_id', $this->match->group_id)
                        ->orderBy('rank')
                        ->take($this->category->number_of_winners_per_group)
                        ->update(['has_qualified' => true]);
                }

                $groupsCount = Group::where('tournament_level_category_id',$this->category->id)->count();
                $completedGroupsCount = Group::where('tournament_level_category_id',$this->category->id)->where('is_completed', true)->count();

                if ($completedGroupsCount == $groupsCount) {
                    $this->category->update(['is_group_stages_completed' => true]);
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

    #[On('storeDateTime')]
    public function storeDateTime($matchId)
    {
        $this->match = Game::with('homeTeam','awayTeam')->findOrFail($matchId);
        $this->match->update([
            'datetime'=>$this->datetimeModel,
        ]);
        return to_route('matches', $this->category->id)->with('success', 'date/time has been updated successfully!');

    }

    public function updateTeamsRank($levelCategoryId)
    {
        $teams = Team::where('level_category_id', $levelCategoryId)->orderBy('points', 'desc')->get();
        $teams->each(function ($team, $index) {
            $team->update(['rank' => $index + 1]);
        });
    }


    public function render()
    {
        return view('livewire.matches.matches-index');
    }
}
