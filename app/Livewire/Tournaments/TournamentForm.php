<?php

namespace App\Livewire\Tournaments;

use App\Models\LevelCategory;
use App\Models\TournamentType;
use Livewire\Component;

class TournamentForm extends Component
{
    public bool $editing = false;
    public $levelCategories = [];
    public $selectedCategoriesIds = [];
    public $tournamentTypes = [];
    public $status;

    public function mount($id = 0, $status = 0)
    {
        $this->levelCategories = LevelCategory::all();
        $this->tournamentTypes = TournamentType::all();
        $this->status = $status;
    }

    public function removeCategory($categoryId)
    {
        $index = array_search($categoryId, $this->selectedCategoriesIds);
        if ($index !== false) {
            unset($this->selectedCategoriesIds[$index]);
            $this->selectedCategoriesIds = array_values($this->selectedCategoriesIds);
        }
        $this->dispatch('selectCategories', $this->selectedCategoriesIds);
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-form');
    }
}
