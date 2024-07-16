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
