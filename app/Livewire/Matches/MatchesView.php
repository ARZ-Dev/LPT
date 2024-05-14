<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\KnockoutRound;
use App\Models\Set;
use App\Models\Team;
use App\Models\TournamentLevelCategory;
use App\Models\TournamentTypeSettings;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;



class MatchesView extends Component
{
    public $matches = [];
    public $match ;
    public $category;
    public $tournament;
    public $matchDate;
    public $absentTeamId;


    public function mount($categoryId)
    {
        $this->authorize('matches-list');
        $this->category = TournamentLevelCategory::with('tournament.levelCategories', 'type')->findOrFail($categoryId);
        $this->tournament = $this->category->tournament;
        $this->matches = Game::with('knockoutRound','homeTeam','awayTeam', 'startedBy')
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
            $this->updateMatchWinner($matchId, $winnerId);

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
        $this->validate([
            'matchDate' => ['after_or_equal:' . $this->category->start_date . " 00:00", 'before_or_equal:' . $this->category->end_date . " 23:59"],
        ]);

        $this->match = Game::with('homeTeam','awayTeam')->findOrFail($matchId);
        $this->match->update([
            'datetime'=>$this->matchDate,
        ]);
        return to_route('matches', $this->category->id)->with('success', 'date/time has been updated successfully!');
    }

    #[On('storeAbsent')]
    public function storeAbsent($matchId)
    {
        $this->validate([
            'absentTeamId' => ['required']
        ]);

        DB::beginTransaction();
        try {

            self::chooseAbsentTeam($matchId, $this->absentTeamId);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('matches', $this->category->id)->with('success', 'Absent team has been updated successfully!');
    }

    public static function chooseAbsentTeam($matchId, $absentTeamId)
    {
        $match = Game::findOrFail($matchId);
        $winnerTeam = $absentTeamId == $match->home_team_id ? $match->awayTeam : $match->homeTeam;
        $match->update([
            'winner_team_id' => $winnerTeam->id,
            'loser_team_id' => $absentTeamId,
            'is_started' => 1,
            'started_at' => now(),
            'started_by' => auth()->id(),
            'is_completed' => 1,
            'completed_at' => now(),
        ]);

        $stageSettings = $match->type == "Knockouts" ? $match->knockoutRound->knockoutStage : $match->group->groupStage;
        throw_if(!$stageSettings->nb_of_sets || !$stageSettings->nb_of_games, new \Exception($stageSettings->name . " settings are required!"));

        for ($i = 1; $i <= $stageSettings->nb_of_sets; $i++) {

            $homeTeamScore = $winnerTeam->id == $match->home_team_id ? $stageSettings->nb_of_games : 0;
            $awayTeamScore = $winnerTeam->id == $match->away_team_id ? $stageSettings->nb_of_games : 0;

            Set::create([
                'game_id' => $match->id,
                'set_number' => $i,
                'home_team_score' => $homeTeamScore,
                'away_team_score' => $awayTeamScore,
                'winner_team_id' => $winnerTeam->id,
                'is_completed' => true,
                'completed_at' => now(),
            ]);
        }

        self::updateMatchWinner($matchId, $winnerTeam->id);
    }

    public static function updateTeamsRank($levelCategoryId)
    {
        $teams = Team::where('level_category_id', $levelCategoryId)->orderBy('points', 'desc')->get();
        $teams->each(function ($team, $index) {
            $team->update(['rank' => $index + 1]);
        });
    }



    /**
     * @param $matchId
     * @param $winnerId
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed
     */
    public static function updateMatchWinner($matchId, $winnerId): mixed
    {
        $match = Game::with('homeTeam', 'awayTeam', 'knockoutRound', 'group')->findOrFail($matchId);
        $category = $match->type == "Knockouts" ? $match->knockoutRound->tournamentLevelCategory : $match->group->tournamentLevelCategory;
        $tournament = $category->tournament;

        if ($match->home_team_id == $winnerId) {
            $loserTeamId = $match->away_team_id;
        } else {
            $loserTeamId = $match->home_team_id;
        }

        $match->update([
            'winner_team_id' => $winnerId,
            'loser_team_id' => $loserTeamId,
            'is_completed' => 1,
            'completed_at' => now(),
        ]);

        $match->homeTeam->increment('matches');
        $match->awayTeam->increment('matches');
        $match->winnerTeam->increment('wins');
        $match->loserTeam->increment('losses');

        if ($match->type == "Knockouts") {
            $relatedHomeGame = Game::where('related_home_game_id', $match->id)->first();
            if ($relatedHomeGame) {
                $relatedHomeGame->update([
                    'home_team_id' => $winnerId
                ]);
            }

            $relatedAwayGame = Game::where('related_away_game_id', $match->id)->first();
            if ($relatedAwayGame) {
                $relatedAwayGame->update([
                    'away_team_id' => $winnerId
                ]);
            }

            $roundPoints = TournamentTypeSettings::where('tournament_type_id', $category->tournament_type_id)
                ->where('stage', $match->knockoutRound?->knockoutStage?->name)
                ->first()?->points ?? 0;
            $match->loserTeam->increment('points', $roundPoints);

            $match->knockoutRound->update([
                'is_completed' => true,
            ]);

            $knockoutStage = $match->knockoutRound->knockoutStage;
            $completedRoundsCount = KnockoutRound::where('knockout_stage_id', $knockoutStage->id)->where('is_completed', true)->count();
            if ($completedRoundsCount == $knockoutStage->knockoutRounds()->count()) {
                $knockoutStage->update([
                    'is_completed' => true,
                ]);
            }

            if ($match->knockoutRound->name == "Final") {
                $category->update([
                    'is_completed' => true,
                    'winner_team_id' => $winnerId,
                    'silver_team_id' => $loserTeamId,
                ]);

                $match->winnerTeam->increment('points', $category->type->points);

                self::updateTeamsRank($category->level_category_id);

                $completedCategoriesCount = $tournament->levelCategories()->where('is_completed', true)->count();
                if (count($tournament->levelCategories) == $completedCategoriesCount) {
                    $tournament->update([
                        'is_completed' => true,
                    ]);
                }
            }

        } else {
            $group = Group::findOrFail($match->group_id);
            $groupTeams = GroupTeam::where('group_id', $match->group_id)->orderBy('wins', 'desc')->get();

            $groupTeamWinner = GroupTeam::where('team_id', $winnerId)->where('group_id', $match->group_id)->first();
            $groupTeamLoser = GroupTeam::where('team_id', $loserTeamId)->where('group_id', $match->group_id)->first();

            $groupTeamWinner->increment('wins');
            $groupTeamWinner->increment('matches_played');
            $groupTeamLoser->increment('losses');
            $groupTeamLoser->increment('matches_played');

            $groupTeams->each(function ($team, $index) {
                $team->update(['rank' => $index + 1]);
            });

            $matchesPlayedCount = GroupTeam::where('group_id', $match->group_id)->where('matches_played', $groupTeams->count() - 1)->count();

            if ($matchesPlayedCount == $groupTeams->count()) {

                $group->update(['is_completed' => true]);

                GroupTeam::where('group_id', $match->group_id)
                    ->orderBy('rank')
                    ->take($category->number_of_winners_per_group)
                    ->update(['has_qualified' => true]);
            }

            $stage = $match->group->knockoutStage;

            $groupsCount = Group::where('tournament_level_category_id', $category->id)->count();
            $completedGroupsCount = Group::where('tournament_level_category_id', $category->id)->where('is_completed', true)->count();

            if ($completedGroupsCount == $groupsCount) {
                $category->update(['is_group_stages_completed' => true]);

                $stage->update([
                    'is_completed' => true,
                ]);
            }
        }
        return $category;
    }


    public function render()
    {
        return view('livewire.matches.matches-index');
    }

}
