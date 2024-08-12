<?php

namespace App\Livewire\Teams;

use App\Models\LevelCategory;
use Livewire\Component;

class TeamsRanking extends Component
{
    public $categories = [];

    public function mount()
    {
        $this->categories = LevelCategory::with(['teams' => function ($query) {
            $query->orderBy('rank');
        }])->get();
    }

    public function render()
    {
        return view('livewire.teams.teams-ranking');
    }
}
