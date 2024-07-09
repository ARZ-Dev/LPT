<?php

namespace App\Livewire\Matches;

use App\Models\Game;
use App\Utils\Constants;
use Livewire\Component;

class MatchesForm extends Component
{
    public bool $editing = false;
    public $levelCategories = [];
    public $status;

    public $matches ;
    public $type;
    public $knockout_round_id;
    public $home_team_id;
    public $away_team_id;



    public function mount($id = 0, $status = 0)
    {

        $this->status = $status;

        if ($id) {

            if ($id == Constants::VIEW_STATUS) {
                $this->authorize('matches-view');
            }

            $this->matches = Game::with(['knockoutRound','homeTeam','awayTeam'])->findOrFail($id);

            $this->editing = true;
            $this->type = $this->matches->type;
            $this->knockout_round_id = $this->matches->knockout_round_id;
            $this->home_team_id = $this->matches->home_team_id;
            $this->away_team_id = $this->matches->away_team_id;

        }
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.matches.matches-view');
        }
    }
}
