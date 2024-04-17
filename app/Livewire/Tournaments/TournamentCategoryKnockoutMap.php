<?php

namespace App\Livewire\Tournaments;

use App\Models\Tournament;
use App\Models\TournamentLevelCategory;
use Livewire\Component;

class TournamentCategoryKnockoutMap extends Component
{
    public $category;
    public $semiFinal;
    public $final;



    public function mount($categoryId)
    {
        // $this->category = TournamentLevelCategory::with(['knockoutStages', 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);

        $this->category = TournamentLevelCategory::with(['knockoutStages','knockoutsMatches' => function ($query) {
            $query->whereNotNull('home_team_id')->whereNotNull('away_team_id')->whereBetween('knockout_round_id', [1, 4]);
        }, 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);
        // dd($this->category);

        $this->semiFinal = TournamentLevelCategory::with(['knockoutStages','knockoutsMatches' => function ($query) {
            $query->whereNotNull('home_team_id')->whereNotNull('away_team_id')->whereBetween('knockout_round_id', [5, 6]);
        }, 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);

        $this->final = TournamentLevelCategory::with(['knockoutStages','knockoutsMatches' => function ($query) {
            $query->whereNotNull('home_team_id')->whereNotNull('away_team_id')->where('knockout_round_id', 7);
        }, 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);
   
        // dd($this->semiFinal);
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-category-knockoutMap');
    }
}
