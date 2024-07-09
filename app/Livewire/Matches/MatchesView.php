<?php

namespace App\Livewire\Matches;

use App\Livewire\Tournaments\TournamentCategoryForm;
use App\Models\Game;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\KnockoutRound;
use App\Models\Player;
use App\Models\Set;
use App\Models\Team;
use App\Models\TournamentLevelCategory;
use App\Models\TournamentLevelCategoryTeam;
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

        $category = getMatchTournamentCategory($match);
        $typeSettingsLink = route('types.edit', $category->tournament_type_id);
        $settings = TournamentTypeSettings::where('tournament_type_id', $category->tournament_type_id)
            ->where('stage', $match->knockoutRound?->knockoutStage?->name)
            ->first();
        throw_if(!$settings, new \Exception("Tournament type knockout settings are required, please go to <a href='$typeSettingsLink'>this link</a> to add them!"));

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

        $stageSettings = $match->type == "Knockouts" ? $match->knockoutRound->knockoutStage : $match->group->knockoutStage;
        throw_if(!$stageSettings?->nb_of_sets || !$stageSettings?->nb_of_games, new \Exception($stageSettings?->name . " settings are required!"));

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

        $match->update([
            'status' => 'forfeited',
        ]);
    }

    public static function updateTeamsRank($levelCategoryId)
    {
        $teams = Team::where('level_category_id', $levelCategoryId)->orderBy('points', 'desc')->get();
        $teams->each(function ($team, $index) {
            $team->update(['rank' => $index + 1]);
        });

        $players = Player::where('gender', 'male')->orderBy('points', 'desc')->get();
        $players->each(function ($player, $index) {
            $player->update(['rank' => $index + 1]);
        });

        $players = Player::where('gender', 'female')->orderBy('points', 'desc')->get();
        $players->each(function ($player, $index) {
            $player->update(['rank' => $index + 1]);
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
            'status' => 'completed',
        ]);

        $match->homeTeam->increment('matches');
        $match->awayTeam->increment('matches');

        $homeTeamPlayersIds = json_decode(TournamentLevelCategoryTeam::where('tournament_level_category_id', $category->id)->where('team_id', $match->home_team_id)->first()->players_ids ?? "[]");
        $awayTeamPlayersIds = json_decode(TournamentLevelCategoryTeam::where('tournament_level_category_id', $category->id)->where('team_id', $match->away_team_id)->first()->players_ids ?? "[]");

        Player::whereIn('id', $homeTeamPlayersIds)->orWhereIn('id', $awayTeamPlayersIds)->increment('matches');

        $match->winnerTeam->increment('wins');
        $match->loserTeam->increment('losses');

        if ($match->home_team_id == $match->winner_team_id) {
            Player::whereIn('id', $homeTeamPlayersIds)->increment('wins');
            Player::whereIn('id', $awayTeamPlayersIds)->increment('losses');
        } else {
            Player::whereIn('id', $homeTeamPlayersIds)->increment('losses');
            Player::whereIn('id', $awayTeamPlayersIds)->increment('wins');
        }

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

            TournamentLevelCategoryTeam::where('tournament_level_category_id', $category->id)->where('team_id', $loserTeamId)->update([
                'last_rank' => $match->knockoutRound?->knockoutStage?->name,
            ]);

            $roundPoints = TournamentTypeSettings::where('tournament_type_id', $category->tournament_type_id)
                ->where('stage', $match->knockoutRound?->knockoutStage?->name)
                ->first()?->points ?? 0;
            $match->loserTeam->increment('points', $roundPoints);

            if ($match->home_team_id == $match->loser_team_id) {
                Player::whereIn('id', $homeTeamPlayersIds)->increment('points', $roundPoints);
            } else {
                Player::whereIn('id', $awayTeamPlayersIds)->increment('points', $roundPoints);
            }

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

                TournamentLevelCategoryTeam::where('tournament_level_category_id', $category->id)->where('team_id', $winnerId)->update([
                    'last_rank' => 'Winner',
                ]);

                $match->winnerTeam->increment('points', $category->type->points);

                if ($match->home_team_id == $match->winner_team_id) {
                    Player::whereIn('id', $homeTeamPlayersIds)->increment('points', $category->type->points);
                } else {
                    Player::whereIn('id', $awayTeamPlayersIds)->increment('points', $category->type->points);
                }

                $completedCategoriesCount = $tournament->levelCategories()->where('is_completed', true)->count();
                if (count($tournament->levelCategories) == $completedCategoriesCount) {
                    $tournament->update([
                        'is_completed' => true,
                    ]);
                }
            }

            self::updateKnockoutsTeamsScore($category->id, $matchId);

        } else {
            $group = Group::findOrFail($match->group_id);

            $groupTeamWinner = GroupTeam::where('team_id', $winnerId)->where('group_id', $match->group_id)->first();
            $groupTeamLoser = GroupTeam::where('team_id', $loserTeamId)->where('group_id', $match->group_id)->first();

            $groupTeamWinner->increment('wins');
            $groupTeamWinner->increment('matches_played');
            $groupTeamLoser->increment('losses');
            $groupTeamLoser->increment('matches_played');

            self::updateTeamsScore($group->id, $match->id);

            $groupTeams = GroupTeam::where('group_id', $match->group_id)
                ->orderByDesc('wins')
                ->orderByDesc('score')
                ->get();

            self::updateGroupTeamRanks($groupTeams);

            $matchesPlayedCount = GroupTeam::where('group_id', $match->group_id)->where('matches_played', $groupTeams->count() - 1)->count();

            if ($matchesPlayedCount == $groupTeams->count()) {

                $teamsToQualify = GroupTeam::where('group_id', $match->group_id)
                    ->orderBy('rank')
                    ->whereBetween('rank', [1, $category->number_of_winners_per_group])
                    ->get();

                if (count($teamsToQualify) == $category->number_of_winners_per_group) {

                    $group->update([
                        'is_completed' => true,
                        'qualification_status' => 'completed',
                    ]);

                    GroupTeam::where('group_id', $match->group_id)
                        ->orderBy('rank')
                        ->take($category->number_of_winners_per_group)
                        ->update([
                            'has_qualified' => true
                        ]);

                    $notQualifiedTeamsIds = GroupTeam::where('group_id', $match->group_id)->where('has_qualified', false)->pluck('team_id')->toArray();
                    TournamentLevelCategoryTeam::where('tournament_level_category_id', $category->id)->whereIn('team_id', $notQualifiedTeamsIds)->update([
                        'last_rank' => 'Group Stages',
                    ]);

                    $roundPoints = TournamentTypeSettings::where('tournament_type_id', $category->tournament_type_id)
                        ->where('stage', 'Group Stages')
                        ->first()?->points ?? 0;

                    Team::whereIn('id', $notQualifiedTeamsIds)->increment('points', $roundPoints);

                    foreach ($notQualifiedTeamsIds as $notQualifiedTeamsId) {
                        $playersIds = json_decode(TournamentLevelCategoryTeam::where('tournament_level_category_id', $category->id)->where('team_id', $notQualifiedTeamsId)->first()?->players_ids ?? "[]");
                        Player::whereIn('id', $playersIds)->increment('points', $roundPoints);
                    }

                } else {

                    // Find drawn teams
                    $multipleRank = null;
                    foreach ($teamsToQualify as $team) {
                        $sameRankTeams = $groupTeams->where('rank', $team->rank);
                        if ($sameRankTeams->count() > 1) {
                            $multipleRank = $team->rank;
                        }
                    }

                    $drawnTeamsIds = $groupTeams->where('rank', $multipleRank)->pluck('team_id')->toArray();

                    GroupTeam::where('group_id', $match->group_id)
                        ->where('rank', '<', $category->number_of_winners_per_group)
                        ->whereNot('rank', $multipleRank)
                        ->update([
                            'has_qualified' => true
                        ]);

                    $group->update([
                        'qualification_status' => 'draw',
                        'drawn_teams_ids' => json_encode($drawnTeamsIds),
                    ]);
                }
            }

            $stage = $match->group->knockoutStage;

            $groupsCount = Group::where('tournament_level_category_id', $category->id)->count();
            $completedGroupsCount = Group::where('tournament_level_category_id', $category->id)->where('is_completed', true)->count();

            if ($completedGroupsCount == $groupsCount) {
                $category->update(['is_group_stages_completed' => true]);

                $stage->update([
                    'is_completed' => true,
                ]);

                (new \App\Livewire\Tournaments\TournamentCategoryForm)->generateMatches($category->id);
            }
        }

        self::updateTeamsRank($category->level_category_id);

        return $category;
    }

    /**
     * @param $groupTeams
     * @return void
     */
    public static function updateGroupTeamRanks($groupTeams): void
    {
        $currentRank = 1;
        $previousTeam = null;

        foreach ($groupTeams as $team) {
            if ($previousTeam && $previousTeam->wins === $team->wins && $previousTeam->score === $team->score) {
                $team->update(['rank' => $previousTeam->rank]);
            } else {
                $team->update(['rank' => $currentRank]);
            }

            $previousTeam = $team;
            $currentRank++;
        }
    }

    public static function updateTeamsScore($groupId, $matchId)
    {
        $group = Group::with('groupTeams')->findOrFail($groupId);
        $match = Game::with(['homeTeam', 'awayTeam'])->findOrFail($matchId);

        $homeTeam = $match->homeTeam;
        $homeTeamScore = $match->sets()->sum('home_team_score') - $match->sets()->sum('away_team_score');
        $awayTeam = $match->awayTeam;
        $awayTeamScore = $match->sets()->sum('away_team_score') - $match->sets()->sum('home_team_score');

        $group->groupTeams()->where('team_id', $homeTeam->id)->increment('score', $homeTeamScore);
        $group->groupTeams()->where('team_id', $awayTeam->id)->increment('score', $awayTeamScore);
    }

    public static function updateKnockoutsTeamsScore($categoryId, $matchId)
    {
        $match = Game::with(['homeTeam', 'awayTeam'])->findOrFail($matchId);

        $homeTeam = $match->homeTeam;
        $homeTeamScore = $match->sets()->sum('home_team_score') - $match->sets()->sum('away_team_score');
        $awayTeam = $match->awayTeam;
        $awayTeamScore = $match->sets()->sum('away_team_score') - $match->sets()->sum('home_team_score');

        TournamentLevelCategoryTeam::where('tournament_level_category_id', $categoryId)->where('team_id', $homeTeam->id)->increment('score', $homeTeamScore);
        TournamentLevelCategoryTeam::where('tournament_level_category_id', $categoryId)->where('team_id', $awayTeam->id)->increment('score', $awayTeamScore);
    }

    public function render()
    {
        return view('livewire.matches.matches-index');
    }

}
