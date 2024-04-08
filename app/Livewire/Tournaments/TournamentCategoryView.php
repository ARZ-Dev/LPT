<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Livewire\Component;

class TournamentCategoryView extends Component
{
    public $tournamentCategories = [];
    public $tournament;

    public function mount($tournamentId)
    {
        $this->tournament = Tournament::findOrFail($tournamentId);
        $this->tournamentCategories = TournamentLevelCategory::where('tournament_id', $tournamentId)
            ->with(['levelCategory'])
            ->get();
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-category-view');
    }
}
