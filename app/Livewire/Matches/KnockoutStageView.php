<?php

namespace App\Livewire\Matches;

use App\Models\KnockoutStage;
use App\Models\Tournament;
use Livewire\Component;



class KnockoutStageView extends Component
{
    public $knockoutStages;
    public $tournament;

   
    public function mount ($id){

        $this->tournament = Tournament::findOrFail($id);
        $this->knockoutStages = KnockoutStage::with('knockoutRounds', 'tournamentDeuceType', 'games', 'tournamentLevelCategory')->whereHas('tournamentLevelCategory', function ($query) {
        $query->where('tournament_id', $this->tournament->id);
    })->get();

    }

    public function render()
    {
        return view('livewire.matches.knockoutStage-view');
    }
}
