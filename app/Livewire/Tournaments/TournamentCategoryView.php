<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentCategoryView extends Component
{
    public $tournamentCategories = [];
    public $tournament;

    public function mount($tournamentId)
    {
        $this->tournament = Tournament::findOrFail($tournamentId);
        $this->tournamentCategories = TournamentLevelCategory::where('tournament_id', $tournamentId)
            ->with(['levelCategory', 'type'])
            ->get();
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
