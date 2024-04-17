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

        // $this->category = TournamentLevelCategory::with(['knockoutStages','knockoutsMatches.knockoutRound','knockoutsMatches' => function ($query) {
        //     $query->whereNotNull('home_team_id')->whereNotNull('away_team_id')->whereBetween('knockout_round_id', [25, 28]);
        // }, 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);

        //         $this->semiFinal = TournamentLevelCategory::with(['knockoutStages','knockoutsMatches.knockoutRound','knockoutsMatches' => function ($query) {
        //     $query->whereNotNull('home_team_id')->whereNotNull('away_team_id')->whereBetween('knockout_round_id', [29, 30]);
        // }, 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);

        //         $this->final = TournamentLevelCategory::with(['knockoutStages','knockoutsMatches.knockoutRound','knockoutsMatches' => function ($query) {
        //     $query->whereNotNull('home_team_id')->whereNotNull('away_team_id')->where('knockout_round_id', 31);
        // }, 'knockoutsMatches.homeTeam','knockoutsMatches.awayTeam','knockoutsMatches.winnerTeam','knockoutsMatches.looserTeam'])->findOrFail($categoryId);

        $this->category = TournamentLevelCategory::with(['knockoutStages', 'knockoutsMatches.knockoutRound' => function ($query) {
            $query->where('name', 'like', '%Quarter Final%');
        }, 'knockoutsMatches' => function ($query) {
            $query->whereNotNull('home_team_id')->whereNotNull('away_team_id');
        }, 'knockoutsMatches.homeTeam', 'knockoutsMatches.awayTeam', 'knockoutsMatches.winnerTeam', 'knockoutsMatches.loserTeam'])->findOrFail($categoryId);
        
        
        $this->semiFinal = TournamentLevelCategory::with(['knockoutStages', 'knockoutsMatches.knockoutRound' => function ($query) {
            $query->where('name', 'like', '%Semi Final%');
        }, 'knockoutsMatches' => function ($query) {
            $query->whereNotNull('home_team_id')->whereNotNull('away_team_id');
        }, 'knockoutsMatches.homeTeam', 'knockoutsMatches.awayTeam', 'knockoutsMatches.winnerTeam', 'knockoutsMatches.loserTeam'])->findOrFail($categoryId);
       

        $this->final = TournamentLevelCategory::with(['knockoutStages', 'knockoutsMatches.knockoutRound' => function ($query) {
            $query->where('name', 'like', '%Final%');
        }, 'knockoutsMatches' => function ($query) {
            $query->whereNotNull('home_team_id')->whereNotNull('away_team_id');
        }, 'knockoutsMatches.homeTeam', 'knockoutsMatches.awayTeam', 'knockoutsMatches.winnerTeam', 'knockoutsMatches.loserTeam'])->findOrFail($categoryId);
   
        // dd($this->semiFinal);
    }

    public function render()
    {
        return view('livewire.tournaments.tournament-category-knockoutMap');
    }
}
