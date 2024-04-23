<?php

namespace App\Livewire\Matches;

use App\Models\KnockoutStage;
use App\Models\Tournament;
use App\Models\TournamentDeuceType;


use App\Models\TournamentLevelCategory;
use Livewire\Component;



class KnockoutStageView extends Component
{
    public $knockoutStages;
    public $tournament;
    public $TournamentDeuceTypes;

    public $knockoutStage;
    public $knockoutStageValues;
    public $tournamentCategory;

    public function mount($categoryId)
    {
        $this->tournamentCategory = TournamentLevelCategory::with(['knockoutStages', 'tournament'])->findOrFail($categoryId);
        $this->knockoutStages = $this->tournamentCategory->knockoutStages;
        $this->tournament = $this->tournamentCategory->tournament;

        $this->TournamentDeuceTypes = TournamentDeuceType::all();

        $this->knockoutStageValues = [];
        foreach ($this->knockoutStages as $knockoutStage) {
            $this->tournament_deuce_type_id = $knockoutStage->tournament_deuce_type_id;
            $this->nb_of_sets = $knockoutStage->nb_of_sets;
            $this->nb_of_games = $knockoutStage->nb_of_games;
            $this->tie_break = $knockoutStage->tie_break;


            $this->knockoutStageValues[$knockoutStage->id] = [
                'tournament_deuce_type_id' => $this->tournament_deuce_type_id,
                'nb_of_sets' => $this->nb_of_sets,
                'nb_of_games' => $this->nb_of_games,
                'tie_break' => $this->tie_break,

            ];
        }
    }

    public function submitSettings($id)
    {
        $this->validate([
            'knockoutStageValues' => ['array'],
            'knockoutStageValues.'. $id .'.tournament_deuce_type_id' => ['required'],
            'knockoutStageValues.'. $id .'.nb_of_sets' => ['required'],
            'knockoutStageValues.'. $id .'.nb_of_games' => ['required'],
            'knockoutStageValues.'. $id .'.tie_break' => ['required'],
        ]);

        $this->knockoutStage = KnockoutStage::findOrFail($id);
        $this->knockoutStage->update([
            'tournament_deuce_type_id' => $this->knockoutStageValues[$id]['tournament_deuce_type_id'],
            'nb_of_sets' => $this->knockoutStageValues[$id]['nb_of_sets'],
            'nb_of_games' => $this->knockoutStageValues[$id]['nb_of_games'],
            'tie_break' => $this->knockoutStageValues[$id]['tie_break'],
        ]);

        return to_route('knockoutStage.view', $this->knockoutStage->tournament_level_category_id)->with('success', 'Knockout stages has been updated successfully!');

    }

    public function render()
    {
        return view('livewire.matches.knockout-stages-view');
    }
}
