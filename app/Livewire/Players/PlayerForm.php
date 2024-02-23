<?php

namespace App\Livewire\Players;

use App\Livewire\Forms\PlayerFormData;
use App\Models\Country;
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
    public $countries = [];

    public function mount($id = 0, $status = 0)
    {
        $this->teams = Team::all();
        $this->countries = Country::all();
        $this->status = $status;

        if ($id) {
            $this->authorize('player-edit');
            $player = Player::findOrFail($id);
            $this->form->setPlayer($player);
            $this->editing = true;
        } else {
            $this->authorize('player-create');
        }
    }

    public function store()
    {
        $this->validate();
        $this->form->store();

        return to_route('players')->with('success', 'Player has been added successfully!');
    }

    public function update()
    {
        $this->validate();
        $this->form->update();

        return to_route('players')->with('success', 'Player has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.players.player-form');
    }
}
