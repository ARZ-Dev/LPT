<?php

namespace App\Livewire\Matches;

use App\Models\KnockoutStage;
use App\Models\Tournament;
use App\Models\TournamentDeuceType;


use Livewire\Component;



class KnockoutStageView extends Component
{
    public $knockoutStages;
    public $tournament;
    public $TournamentDeuceTypes;
    
    public $knockoutStage;
    public $tournament_deuce_type_id;
    public $nb_of_sets;
    public $nb_of_games;
    public $knockoutStageValues;

   
    public function mount ($id){

        $this->tournament = Tournament::findOrFail($id);
        $this->knockoutStages = KnockoutStage::with('knockoutRounds', 'tournamentDeuceType', 'games', 'tournamentLevelCategory')->whereHas('tournamentLevelCategory', function ($query) {
        $query->where('tournament_id', $this->tournament->id);
        })->get();

        $this->TournamentDeuceTypes = TournamentDeuceType::all();

        $this->knockoutStageValues = [];
        foreach ($this->knockoutStages as $knockoutStage) {
            $this->tournament_deuce_type_id = $knockoutStage->tournament_deuce_type_id;
            $this->nb_of_sets = $knockoutStage->nb_of_sets;
            $this->nb_of_games = $knockoutStage->nb_of_games;
    
            $this->knockoutStageValues[$knockoutStage->id] = [
                'tournament_deuce_type_id' => $this->tournament_deuce_type_id,
                'nb_of_sets' => $this->nb_of_sets,
                'nb_of_games' => $this->nb_of_games,
            ];
        }
        
    }

    public function actions($id)
    {
        $this->knockoutStage = KnockoutStage::with('knockoutRounds', 'tournamentDeuceType', 'games', 'tournamentLevelCategory')->whereHas('tournamentLevelCategory', function ($query) {
            $query->where('tournament_id', $this->tournament->id);
        })->find($id);

        $this->nb_of_sets =  $this->knockoutStage->nb_of_sets;

        $this->knockoutStage->update([
            'tournament_deuce_type_id'=>$this->tournament_deuce_type_id,
            'nb_of_sets'=>$this->nb_of_sets,
            'nb_of_games'=>$this->nb_of_games,

        ]);
        return to_route('knockoutStage.view', $this->knockoutStage->tournament_level_category_id)->with('success', ' the update has been successful!');

    }

    public function render()
    {
        return view('livewire.matches.knockoutStage-view');
    }
}
