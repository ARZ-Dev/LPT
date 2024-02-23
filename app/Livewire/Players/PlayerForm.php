<?php

namespace App\Livewire\Players;

use App\Livewire\Forms\PlayerFormData;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PlayerForm extends Component
{
    use AuthorizesRequests;

    public bool $editing = false;
    public int $status = 0;
    public $teams = [];
    public PlayerFormData $form;

    public function mount($id = 0, $status = 0)
    {
        $this->teams = Team::all();

        if ($id) {
            $player = Player::findOrFail($id);
            $this->form->setPlayer($player);
        } else {

        }
    }

    public function render()
    {
        return view('livewire.players.player-form');
    }
}
