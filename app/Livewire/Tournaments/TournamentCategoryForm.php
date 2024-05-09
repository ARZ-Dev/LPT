<?php

namespace App\Livewire\Tournaments;

use App\Models\Currency;
use App\Models\Game;
use App\Models\Group;
use App\Models\KnockoutRound;
use App\Models\KnockoutStage;
use App\Models\Receipt;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentDeuceType;
use App\Models\TournamentLevelCategory;
use App\Models\TournamentLevelCategoryTeam;
use App\Models\TournamentType;
use App\Rules\EvenNumber;
use App\Rules\PowerOfTwo;
use App\Rules\PowerOfTwoArray;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentCategoryForm extends Component
{
    public $tournament;
    public $category;
    public $tournamentTypes = [];
    public $type_id;
    public $nb_of_teams;
    public $selectedTeamsIds = [];
    public bool $has_group_stages = false;
    public $nb_of_groups;
    public $nb_of_winners_per_group;
    public $start_date;
    public $end_date;
    public string $teams_filter_search = "";
    public int $knockout_teams = 0;
    public array $fullPayedTeamsIds = [];
    public array $stagesDetails = [];
    public $deuceTypes = [];
    public $defaultCurrency;
    public bool $canEditDetails = true;

    public function mount($tournamentId, $categoryId)
    {
        $this->tournament = Tournament::findOrFail($tournamentId);
        $this->category = TournamentLevelCategory::with([
                'type', 'teams', 'knockoutStages' => ['games' => ['homeTeam', 'awayTeam', 'winnerTeam']], 'knockoutsMatches', 'groupStageMatches'
            ])->findOrFail($categoryId);
        $this->tournamentTypes = TournamentType::all();

        $this->deuceTypes = TournamentDeuceType::all();

        foreach ($this->category->knockoutStages as $knockoutStage) {
            $this->stagesDetails[$knockoutStage->id] = [
                'id' => $knockoutStage->id,
                'tournament_deuce_type_id' => $knockoutStage->tournament_deuce_type_id,
                'nb_of_sets' => $knockoutStage->nb_of_sets,
                'nb_of_games' => $knockoutStage->nb_of_games,
                'tie_break' => $knockoutStage->tie_break,
            ];
        }

        $this->canEditDetails = !$this->category->is_group_matches_generated && !$this->category->is_knockout_matches_generated;

        $this->type_id = $this->category->tournament_type_id;
        $this->nb_of_teams = $this->category->number_of_teams;
        $this->start_date = $this->category->start_date;
        $this->end_date = $this->category->end_date;
        $this->selectedTeamsIds = $this->category->teams->pluck('team_id')->toArray();
        $this->has_group_stages = $this->category->has_group_stage;
        $this->nb_of_groups = $this->category->number_of_groups;
        $this->nb_of_winners_per_group = $this->category->number_of_winners_per_group;

        // Get the teams that have paid the subscription fee for this tournament
        $this->defaultCurrency = Currency::where('is_default', true)->first();
        $subscriptionFee = $this->category->subscription_fee;

        $teams = Team::whereHas('receipts', function ($query) {
                $query->where('tournament_id', $this->tournament->id);
            })
            ->with(['receipts' => function ($query) {
                $query->where('tournament_id', $this->tournament->id);
            }, 'receipts.receiptAmounts.currency'])
            ->get();

        foreach ($teams as $team) {
            $totalPayment = 0;
            foreach ($team->receipts as $receipt) {
                foreach ($receipt->receiptAmounts as $receiptAmount) {
                    if ($receiptAmount->currency_id == $this->defaultCurrency->id) {
                        $totalPayment += $receiptAmount->amount;
                    } else {
                        $totalPayment += $receiptAmount->amount * $receiptAmount->currency?->rate;
                    }
                }
            }

            if ($totalPayment >= $subscriptionFee) {
                $this->fullPayedTeamsIds[] = $team->id;
            }
        }

    }

    public function toggleTeam($teamId)
    {
        if (in_array($teamId, $this->selectedTeamsIds ?? [])) {
            $index = array_search($teamId, $this->selectedTeamsIds);
            unset($this->selectedTeamsIds[$index]);
        } else {
            $this->selectedTeamsIds[] = $teamId;
        }
        $this->selectedTeamsIds = array_unique($this->selectedTeamsIds);
        $this->nb_of_teams = count($this->selectedTeamsIds);
    }

    public function rules()
    {
        $rules = [
            'type_id' => ['required'],
            'nb_of_teams' => ['required', 'numeric', new EvenNumber(), 'min:2'],
            'has_group_stages' => ['boolean'],
            'nb_of_groups' => ['required_if:has_group_stages,true'],
            'nb_of_winners_per_group' => ['required_if:has_group_stages,true'],
            'start_date' => ['required', 'date', 'after_or_equal:' . $this->tournament->start_date],
            'end_date' => ['required', 'date', 'after_or_equal:start_date', 'before_or_equal:' . $this->tournament->end_date],
        ];

        if ($this->has_group_stages) {
            $this->knockout_teams = $this->nb_of_groups * $this->nb_of_winners_per_group;
            $rules['knockout_teams'] = ['required', 'gte:2', new PowerOfTwo()];
            $rules['selectedTeamsIds'] = ['required', 'array', 'min:' . ($this->nb_of_groups ?? 0) * 2];
        } else {
            $rules['selectedTeamsIds'] = ['required', 'array', 'min:2', new PowerOfTwoArray()];
        }

        return $rules;
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();
        try {

            throw_if(!$this->canEditDetails, new \Exception("Something went wrong!"));

            $this->category->update([
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'tournament_type_id' => $this->type_id,
                'number_of_teams' => count($this->selectedTeamsIds),
                'has_group_stage' => $this->has_group_stages ?? false,
                'number_of_groups' => ($this->has_group_stages ?? false) ? $this->nb_of_groups : NULL,
                'number_of_winners_per_group' => ($this->has_group_stages ?? false) ? $this->nb_of_winners_per_group : NULL,
            ]);

            $categoryTeamsIds = [];
            $playersIds = [];
            foreach ($this->selectedTeamsIds as $teamId) {

                $team = Team::with('players')->find($teamId);
                throw_if(count($team->players) != 2, new \Exception($team->nickname . " team must have exactly 2 players."));

                foreach ($team->players as $player) {
//                    throw_if(in_array($player->id, $playersIds), new \Exception("The player: ". $player->full_name . ", cannot exists in multiple teams in the same tournament!"));
                    $playersIds[] = $player->id;
                }

                $categoryTeam = TournamentLevelCategoryTeam::updateOrCreate([
                    'tournament_level_category_id' => $this->category->id,
                    'team_id' => $teamId,
                    'players_ids' => json_encode($team->players->pluck('id')->toArray()),
                ]);
                $categoryTeamsIds[] = $categoryTeam->id;
            }
            TournamentLevelCategoryTeam::where('tournament_level_category_id', $this->category->id)
                ->whereNotIn('id', $categoryTeamsIds)
                ->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);

        }

        return $this->dispatch('swal:success', [
            'title' => 'Great!',
            'text'  => "Details has been saved successfully!",
        ]);
    }

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

        return $this->dispatch('swal:success', [
            'title' => 'Great!',
            'text'  => "Matches has been generated successfully!",
        ]);
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

    public function storeStages()
    {
        $this->validate([
            'stagesDetails.*.tournament_deuce_type_id' => ['required'],
            'stagesDetails.*.nb_of_sets' => ['required'],
            'stagesDetails.*.nb_of_games' => ['required'],
            'stagesDetails.*.tie_break' => ['required'],
        ]);

        foreach ($this->stagesDetails as $stagesDetail) {
            $stage = KnockoutStage::find($stagesDetail['id']);
            $stage->update([
                'tournament_deuce_type_id' => $stagesDetail['tournament_deuce_type_id'],
                'nb_of_sets' => $stagesDetail['nb_of_sets'],
                'nb_of_games' => $stagesDetail['nb_of_games'],
                'tie_break' => $stagesDetail['tie_break'],
            ]);
        }

        return $this->dispatch('swal:success', [
            'title' => 'Great!',
            'text'  => "Stages settings has been updated successfully!",
        ]);
    }

    public function render()
    {
        $data = [];
        $teams = Team::where('level_category_id', $this->category->level_category_id)
            ->where('nickname', 'like', '%' . $this->teams_filter_search . '%')
            ->when(!$this->tournament->is_free, function ($query) {
                $query->whereIn('id', $this->fullPayedTeamsIds);
            })
            ->with(['receipts' => ['receiptAmounts']])
            ->get();

        $data['teams'] = $teams;

        return view('livewire.tournaments.tournament-category-form', $data);
    }
}
