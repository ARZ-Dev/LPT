<?php

namespace App\Livewire\Players;

use App\Models\Player;
use Livewire\Component;

class PlayerView extends Component
{
    public $players = [];

    protected $listeners = [
        'delete'
    ];
    public function mount()
    {
        $this->players = Player::with(['currentTeam', 'teams'])->get();
    }

    public function delete($id)
    {
        $player = Player::find($id);

        $player->delete();

        return to_route('players')->with('success', 'Player has been deleted successfully!');
    }

    public function render()
    {
        return view('livewire.players.player-index');
    }
}
