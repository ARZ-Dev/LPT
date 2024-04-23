<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Livewire\Component;

class TournamentCategoryKnockoutMap extends Component
{
    public $category;

    public function mount($categoryId)
    {
        $this->category = TournamentLevelCategory::with(['knockoutStages.games'])->findOrFail($categoryId);
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-category-knockoutMap2');
    }
}
