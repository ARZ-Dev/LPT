<?php

namespace App\Livewire\Tournaments;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use App\Models\TournamentLevelCategoryTeam;
use App\Models\TournamentType;
use App\Rules\EvenNumber;
use Livewire\Component;

class TournamentCategoryForm extends Component
{
    public $tournament;
    public $tournamentLevelCategory;
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

    public function mount($tournamentId, $categoryId)
    {
        $this->tournament = Tournament::findOrFail($tournamentId);
        $this->tournamentLevelCategory = TournamentLevelCategory::with([
                'type', 'teams'
            ])->findOrFail($categoryId);
        $this->tournamentTypes = TournamentType::all();

        $this->type_id = $this->tournamentLevelCategory->tournament_type_id;
        $this->nb_of_teams = $this->tournamentLevelCategory->number_of_teams;
        $this->start_date = $this->tournamentLevelCategory->start_date;
        $this->end_date = $this->tournamentLevelCategory->end_date;
        $this->selectedTeamsIds = $this->tournamentLevelCategory->teams->pluck('team_id')->toArray();
        $this->has_group_stages = $this->tournamentLevelCategory->has_group_stage;
        $this->nb_of_groups = $this->tournamentLevelCategory->number_of_groups;
        $this->nb_of_winners_per_group = $this->tournamentLevelCategory->number_of_winners_per_group;
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
        return [
            'type_id' => ['required'],
            'nb_of_teams' => ['required', 'numeric', new EvenNumber(), 'min:2'],
            'selectedTeamsIds' => ['required', 'array', 'min:2'],
            'has_group_stages' => ['boolean'],
            'nb_of_groups' => ['required_if:has_group_stages,true'],
            'nb_of_winners_per_group' => ['required_if:has_group_stages,true'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function update()
    {
        $this->validate();

        $this->tournamentLevelCategory->update([
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'tournament_type_id' => $this->type_id,
            'number_of_teams' => count($this->selectedTeamsIds),
            'has_group_stage' => $this->has_group_stages ?? false,
            'number_of_groups' => ($this->has_group_stages ?? false) ? $this->nb_of_groups : NULL,
            'number_of_winners_per_group' => ($this->has_group_stages ?? false) ? $this->nb_of_winners_per_group : NULL,
        ]);

        $categoryTeamsIds = [];
        foreach ($this->selectedTeamsIds as $teamId) {
            $categoryTeam = TournamentLevelCategoryTeam::updateOrCreate([
                'tournament_level_category_id' => $this->tournamentLevelCategory->id,
                'team_id' => $teamId,
            ]);
            $categoryTeamsIds[] = $categoryTeam->id;
        }
        TournamentLevelCategoryTeam::where('tournament_level_category_id', $this->tournamentLevelCategory->id)
            ->whereNotIn('id', $categoryTeamsIds)
            ->delete();

        return to_route('tournaments-categories', $this->tournament->id)->with('success', 'Tournament category has been updated successfully!');
    }

    public function render()
    {
        $data = [];
        $teams = Team::where('level_category_id', $this->tournamentLevelCategory->level_category_id)
            ->where('nickname', 'like', '%' . $this->teams_filter_search . '%')
            ->get();
        $data['teams'] = $teams;

        return view('livewire.tournaments.tournament-category-form', $data);
    }
}
