<?php

namespace App\Livewire\Tournaments;

use App\Models\LevelCategory;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use App\Models\TournamentLevelCategoryTeam;
use App\Models\TournamentType;
use App\Rules\EvenNumber;
use App\Utils\Constants;
use Livewire\Component;

class TournamentForm extends Component
{
    public bool $editing = false;
    public $levelCategories = [];
    public $tournamentTypes = [];
    public $status;

    public $tournament = null;
    public $teams;

    // form data
    public $name;
    public array $selectedCategoriesIds = [];
    public $startDate;
    public $endDate;
    public array $categoriesInfo = [];

    public function mount($id = 0, $status = 0)
    {
        $this->levelCategories = LevelCategory::has('teams')->get();
        $this->tournamentTypes = TournamentType::all();
        $this->teams = Team::with('players')->get();
        $this->status = $status;

        if ($id) {

            if ($id == Constants::VIEW_STATUS) {
                $this->authorize('tournament-view');
            } else {
                $this->authorize('tournament-edit');
            }

            $this->tournament = Tournament::with([
                    'levelCategories' => ['teams']
                ])->findOrFail($id);
            $this->editing = true;
            $this->name = $this->tournament->name;
            $this->startDate = $this->tournament->start_date;
            $this->endDate = $this->tournament->end_date;
            $this->selectedCategoriesIds = $this->tournament->levelCategories->pluck('level_category_id')->toArray();

            $this->categoriesInfo = [];
            foreach ($this->tournament->levelCategories as $levelCategory) {
                $this->categoriesInfo[$levelCategory->level_category_id] = [
                    'type_id' => $levelCategory->tournament_type_id,
                    'nb_of_teams' => $levelCategory->number_of_teams,
                    'has_group_stage' => $levelCategory->has_group_stage,
                    'teams' => $levelCategory->teams->pluck('team_id')->toArray(),
                    'nb_of_groups' => $levelCategory->number_of_groups,
                    'nb_of_winners_per_group' => $levelCategory->number_of_winners_per_group,
                ];
            }
        } else {
            $this->authorize('tournament-create');
        }
    }

    public function toggleTeam($categoryId, $teamId)
    {
        if (in_array($teamId, $this->categoriesInfo[$categoryId]['teams'] ?? [])) {
            $index = array_search($teamId, $this->categoriesInfo[$categoryId]['teams']);
            unset($this->categoriesInfo[$categoryId]['teams'][$index]);
        } else {
            $this->categoriesInfo[$categoryId]['teams'][] = $teamId;
        }
        $this->categoriesInfo[$categoryId]['nb_of_teams'] = count($this->categoriesInfo[$categoryId]['teams']);
    }

    public function removeCategory($categoryId)
    {
        $index = array_search($categoryId, $this->selectedCategoriesIds);
        if ($index !== false) {
            unset($this->selectedCategoriesIds[$index]);
            $this->selectedCategoriesIds = array_values($this->selectedCategoriesIds);
            unset($this->categoriesInfo[$categoryId]);
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'selectedCategoriesIds' => ['required', 'array', 'min:1'],
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'categoriesInfo' => ['required', 'array', 'min:1'],
            'categoriesInfo.*.type_id' => ['required'],
            'categoriesInfo.*.nb_of_teams' => ['required', 'numeric', new EvenNumber, 'min:2'],
            'categoriesInfo.*.teams' => ['required', 'array', 'min:2'],
            'categoriesInfo.*.has_group_stage' => ['boolean'],
            'categoriesInfo.*.nb_of_groups' => ['required_if:categoriesInfo.*.has_group_stage,true'],
            'categoriesInfo.*.nb_of_winners_per_group' => ['required_if:categoriesInfo.*.has_group_stage,true'],
        ];
    }

    public function store()
    {
        $this->validate();

        $tournament = Tournament::create([
            'created_by' => auth()->id(),
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        foreach ($this->categoriesInfo as $categoryId => $categoryInfo) {
            $tournamentLevelCategory = $tournament->levelCategories()->create([
                'level_category_id' => $categoryId,
                'tournament_type_id' => $categoryInfo['type_id'],
                'number_of_teams' => $categoryInfo['nb_of_teams'],
                'has_group_stage' => $categoryInfo['has_group_stage'] ?? false,
                'number_of_groups' => ($categoryInfo['has_group_stage'] ?? false) ? $categoryInfo['nb_of_groups'] : NULL,
                'number_of_winners_per_group' => ($categoryInfo['has_group_stage'] ?? false) ? $categoryInfo['nb_of_winners_per_group'] : NULL,
            ]);

            foreach ($categoryInfo['teams'] ?? [] as $teamId) {
                TournamentLevelCategoryTeam::create([
                    'tournament_level_category_id' => $tournamentLevelCategory->id,
                    'team_id' => $teamId,
                ]);
            }
        }

        return to_route('tournaments')->with('success', 'Tournament has been created successfully!');
    }

    public function update()
    {
        $this->validate();

        $this->tournament->update([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        $categoriesIds = [];
        foreach ($this->categoriesInfo as $categoryId => $categoryInfo) {
            $levelCategory = TournamentLevelCategory::updateOrCreate([
                'tournament_id' => $this->tournament->id,
                'level_category_id' => $categoryId,
            ],[
                'tournament_type_id' => $categoryInfo['type_id'],
                'number_of_teams' => $categoryInfo['nb_of_teams'],
                'has_group_stage' => $categoryInfo['has_group_stage'] ?? false,
                'number_of_groups' => $categoryInfo['has_group_stage'] ? $categoryInfo['nb_of_groups'] : NULL,
                'number_of_winners_per_group' => $categoryInfo['has_group_stage'] ? $categoryInfo['nb_of_winners_per_group'] : NULL,
            ]);
            $categoriesIds[] = $levelCategory->id;

            $teamsIds = [];
            foreach ($categoryInfo['teams'] ?? [] as $teamId) {
                $team = TournamentLevelCategoryTeam::updateOrCreate([
                    'tournament_level_category_id' => $levelCategory->id,
                    'team_id' => $teamId,
                ]);
                $teamsIds[] = $team->id;
            }
            TournamentLevelCategoryTeam::where('tournament_level_category_id', $levelCategory->id)->whereNotIn('id', $teamsIds)->delete();

        }
        TournamentLevelCategory::where('tournament_id', $this->tournament->id)->whereNotIn('id', $categoriesIds)->delete();

        return to_route('tournaments')->with('success', 'Tournament has been updated successfully!');
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.tournaments.tournament-view');
        }
        return view('livewire.tournaments.tournament-form');
    }
}
