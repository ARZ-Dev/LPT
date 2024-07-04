<?php

namespace App\Livewire\Tournaments;

use App\Models\TournamentType;
use App\Models\TournamentTypeSettings;
use Livewire\Component;

class TournamentTypeForm extends Component
{
    public $type;
    public $name;
    public $points;
    public $stagePoints = [];

    public function mount($typeId)
    {
        $this->type = TournamentType::with('settings')->findOrFail($typeId);
        $this->name = $this->type->name;
        $this->points = number_format($this->type->points);

        if (count($this->type->settings)) {
            $this->stagePoints = $this->type->settings->toArray();
        } else {
            $stages = ['Group Stages', 'Round of 64', 'Round of 32', 'Round of 16', 'Quarter Final', 'Semi Final', 'Final'];
            foreach ($stages as $stage) {
                $this->stagePoints[] = [
                    'stage' => $stage,
                    'points' => '',
                ];
            }
        }

    }

    public function rules()
    {
        return [
            'type' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'stagePoints.*.stage' => ['required'],
            'stagePoints.*.points' => ['required', 'integer'],
        ];
    }

    public function store()
    {
        $this->validate();

        foreach ($this->stagePoints as $stagePoint) {
            TournamentTypeSettings::updateOrCreate([
                'tournament_type_id' => $this->type->id,
                'stage' => $stagePoint['stage'],
            ],[
                'points' => $stagePoint['points'],
            ]);
        }

        return to_route('types')->with('success', 'Tournament types settings has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-type-form');
    }
}
