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
        $this->teams = Team::with('players')->get();
        $this->status = $status;

        if ($id) {

            if ($id == Constants::VIEW_STATUS) {
                $this->authorize('tournament-view');
            } else {
                $this->authorize('tournament-edit');
            }

            $this->tournament = Tournament::with(['createdBy',
                    'levelCategories.levelCategory' => ['teams']
                ])->findOrFail($id);
            $this->editing = true;
            $this->name = $this->tournament->name;
            $this->startDate = $this->tournament->start_date;
            $this->endDate = $this->tournament->end_date;
            $this->selectedCategoriesIds = $this->tournament->levelCategories->pluck('level_category_id')->toArray();
        } else {
            $this->authorize('tournament-create');
        }
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

        foreach ($this->selectedCategoriesIds as $categoryId) {
            $tournament->levelCategories()->create([
                'level_category_id' => $categoryId,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
            ]);
        }

        return to_route('tournaments-categories', $tournament->id)->with('success', 'Tournament has been created successfully!');
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
        foreach ($this->selectedCategoriesIds as $categoryId) {
            $levelCategory = TournamentLevelCategory::where('tournament_id', $this->tournament->id)->where('level_category_id', $categoryId)->first();
            if (!$levelCategory) {
                $levelCategory = TournamentLevelCategory::create([
                    'tournament_id' => $this->tournament->id,
                    'level_category_id' => $categoryId,
                    'start_date' => $this->startDate,
                    'end_date' => $this->endDate,
                ]);
            }

            $categoriesIds[] = $levelCategory->id;
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
