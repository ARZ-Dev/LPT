<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Livewire\Component;

class TournamentCategoryKnockoutMap extends Component
{
    public $category;
    public $final;

    
    public function mount($categoryId)
    {

        // $this->category = TournamentLevelCategory::with('knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam')->findOrFail($categoryId);
        
        $this->category = TournamentLevelCategory::with(['knockoutsMatches' => function ($query) {
            $query->where('knockout_round_id', '!=', 12)
                  ->with('winnerTeam', 'looserTeam');
        }])->findOrFail($categoryId);
        

        $this->final = TournamentLevelCategory::with(['knockoutsMatches' => function ($query) {
            $query->where('knockout_round_id', 12)
                  ->with('winnerTeam', 'looserTeam');
        }])->findOrFail($categoryId);
     

    }


    public function render()
    {
      
        return view('livewire.tournaments.tournament-category-knockoutMap');
    }
}