<?php

namespace App\Livewire\GroupStages;

use App\Models\TournamentLevelCategory;
use Livewire\Component;

class GroupStageRanking extends Component
{
    public $category;
    public $groupStage;

    public function mount($categoryId)
    {
        $this->category = TournamentLevelCategory::with(['groups' => ['groupTeams' => function ($query) {
            $query->orderBy('rank');
        }]])->findOrFail($categoryId);
    }

    public function render()
    {
        return view('livewire.group-stages.group-stage-ranking');
    }
}
