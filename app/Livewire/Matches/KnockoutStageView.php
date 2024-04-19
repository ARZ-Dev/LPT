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

        $this->knockoutStages =KnockoutStage::with('knockoutRounds','tournamentDeuceType','games')->get();
        $this->tournament = Tournament::findOrFail($id);


    }

    public function render()
    {
        return view('livewire.matches.knockoutStage-view');
    }
}
