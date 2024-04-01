<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use Livewire\Component;

class TournamentView extends Component
{
    public $tournaments = [];

    public function mount()
    {
        $this->tournaments = Tournament::all();
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-index');
    }
}
