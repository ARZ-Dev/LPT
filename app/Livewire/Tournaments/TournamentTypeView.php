<?php

namespace App\Livewire\Tournaments;

use App\Models\TournamentType;
use Livewire\Component;

class TournamentTypeView extends Component
{
    public $types = [];

    public function mount()
    {
        $this->types = TournamentType::all();
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-type-view');
    }
}
