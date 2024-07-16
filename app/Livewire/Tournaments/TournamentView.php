<?php

namespace App\Livewire\Tournaments;

use App\Models\Game;
use App\Models\Group;
use App\Models\KnockoutRound;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TournamentView extends Component
{
    public $tournaments = [];


    public function mount()
    {
        $this->authorize('tournament-list');
        $this->tournaments = Tournament::with('levelCategories')->get();
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('tournament-delete');

        $tournament = Tournament::with('levelCategories')->findOrFail($id);

        $tournament->levelCategories->each->delete();

        $tournament->delete();

        return to_route('tournaments')->with('success', 'Tournament has been deleted successfully!');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-index');
    }
}
