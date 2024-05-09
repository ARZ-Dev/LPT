<?php

namespace App\Livewire\Tournaments;

use App\Models\Game;
use App\Models\Group;
use App\Models\KnockoutRound;
use App\Models\KnockoutStage;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentCategoryView extends Component
{
    use AuthorizesRequests;
    public $tournamentCategories = [];
    public $tournament;

    public function mount($tournamentId)
    {
        $this->authorize('tournament-categories');

        $this->tournament = Tournament::findOrFail($tournamentId);
        $this->tournamentCategories = TournamentLevelCategory::where('tournament_id', $tournamentId)
            ->with(['levelCategory', 'type', 'knockoutsMatches', 'groupStageMatches'])
            ->get();
    }

    #[On('generateMatches')]
    public function generateMatches($categoryId)
    {
        $this->authorize('tournamentCategory-generateMatches');

        DB::beginTransaction();
        try {
            $category = TournamentLevelCategory::with(['teams', 'groups' => ['teams']])->findOrFail($categoryId);

            $teamsIds = $category->teams->pluck('team_id')->toArray();

            $nbOfTeams = count($teamsIds);
            throw_if($nbOfTeams <= 0, new \Exception("There are no teams selected!"));

            $teams = Team::find($teamsIds);

            if ($category->has_group_stage) {

                if (!$category->is_knockout_matches_generated && !$category->is_group_matches_generated) {


                    throw_if($category->is_group_matches_generated, new \Exception("Group matches has already been generated!"));

                    $groupStage = KnockoutStage::create([
                        'tournament_level_category_id' => $category->id,
                        'name' => "Group Stages",
                    ]);

                    $numberOfGroups = $category->number_of_groups;
                    $teamsPerGroup = ceil($nbOfTeams / $numberOfGroups);

                    $shuffledTeams = $teams->shuffle();
                    for ($i = 1; $i <= $numberOfGroups; $i++) {
                        $group = Group::create([
                            'tournament_level_category_id' => $category->id,
                            'knockout_stage_id' => $groupStage->id,
                            'name' => 'Group ' . $i,
                        ]);

                        $groupTeams = $shuffledTeams->splice(0, $teamsPerGroup);
                        $group->teams()->attach($groupTeams);

                        // Generate matches for each group
                        $teamIds = $group->teams()->pluck('teams.id');
                        $teamCount = count($teamIds);

                        for ($j = 0; $j < $teamCount - 1; $j++) {
                            for ($k = $j + 1; $k < $teamCount; $k++) {
                                Game::create([
                                    'type' => 'Group Stages',
                                    'group_id' => $group->id,
                                    'home_team_id' => $teamIds[$j],
                                    'away_team_id' => $teamIds[$k],
                                ]);
                            }
                        }
                    }

                    $category->update([
                        'is_group_matches_generated' => true,
                    ]);

                } else {

                    throw_if(!$category->is_group_stages_completed, new \Exception("Group stages is not completed yet!"));

                    $qualifiedTeamsIds = [];
                    foreach ($category->groups as $group) {

                        throw_if(!$group->is_completed, new \Exception("$group->name is not completed yet!"));

                        $qualifiedTeams = $group->teams()->where('has_qualified', true)->get();
                        foreach ($qualifiedTeams as $qualifiedTeam) {
                            $qualifiedTeamsIds[] = $qualifiedTeam->id;
                        }
                    }

                    $qualifiedTeams = Team::find($qualifiedTeamsIds);

                    $this->generateKnockoutMatches($category, $qualifiedTeams);

                    $category->update([
                        'is_knockout_matches_generated' => true,
                    ]);

                }

            } else {

                throw_if($category->is_knockout_matches_generated, new \Exception("Knockout matches has already been generated!"));

                $teamsIds = $category->teams->pluck('team_id')->toArray();
                $teams = Team::find($teamsIds);

                $this->generateKnockoutMatches($category, $teams);

                $category->update([
                    'is_knockout_matches_generated' => true,
                ]);
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('tournaments-categories.edit', [$category->tournament_id, $category->id])->with('success', 'Matches has been generated, please set the stage settings before playing the matches!');
    }

    /**
     * @param $teams
     * @param $category
     * @return void
     * @throws \Throwable
     */
    public function generateKnockoutMatches($category, $teams): void
    {
        $nbOfTeams = count($teams);
        throw_if($nbOfTeams <= 0, new \Exception("There are no teams selected!"));

        $matchesPerRound = $nbOfTeams / 2;
        $previousRoundGameIds = [];

        while ($matchesPerRound >= 1) {
            // Determine round name
            $roundName = match ($matchesPerRound) {
                1 => 'Final',
                2 => 'Semi Final',
                4 => 'Quarter Final',
                default => "Round of $nbOfTeams",
            };

            $knockoutStage = KnockoutStage::create([
                'tournament_level_category_id' => $category->id,
                'name' => $roundName,
            ]);

            // Shuffle the teams randomly
            $teams = $teams->shuffle();

            // Initialize an array to store related game IDs for the current round
            $currentRoundGameIds = [];

            // Generate matches for the current knockout round
            for ($i = 0; $i < $matchesPerRound; $i++) {

                // Create or update the knockout round
                $roundNumber = $i + 1;
                $knockoutRoundName = $roundName == "Final" ? $roundName : $roundName . " #$roundNumber";
                $knockoutRound = KnockoutRound::create([
                    'tournament_level_category_id' => $category->id,
                    'knockout_stage_id' => $knockoutStage->id,
                    'name' => $knockoutRoundName,
                ]);

                // Take two teams from the top of the teams list
                $homeTeam = $teams->shift();
                $awayTeam = $teams->shift();

                $relatedHomeGameId = $previousRoundGameIds[$i * 2] ?? null;
                $relatedAwayGameId = $previousRoundGameIds[$i * 2 + 1] ?? null;

                // Create a match for the current knockout round
                $game = Game::create([
                    'type' => 'Knockouts',
                    'knockout_round_id' => $knockoutRound->id,
                    'home_team_id' => $homeTeam?->id,
                    'away_team_id' => $awayTeam?->id,
                    'related_home_game_id' => $relatedHomeGameId,
                    'related_away_game_id' => $relatedAwayGameId,
                ]);

                // Store the game ID for the current match
                $currentRoundGameIds[] = $game->id;
            }

            // Update previous round game IDs after all matches of the current round have been generated
            $previousRoundGameIds = $currentRoundGameIds;

            // Update remaining teams and matches per round for the next iteration
            $nbOfTeams /= 2;
            $matchesPerRound /= 2;
        }
    }

    #[On('delete')]
    public function delete($id)
    {
        $tournamentCategory = TournamentLevelCategory::with('teams')->find($id);

        $tournamentCategory->teams?->each->delete();

        $tournamentCategory->delete();

        return to_route('tournaments-categories', $this->tournament->id)->with('success', 'Tournament category has been deleted successfully!');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-category-view');
    }
}
