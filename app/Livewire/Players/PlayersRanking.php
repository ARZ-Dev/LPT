<?php

namespace App\Livewire\Players;

use App\Models\Player;
use Livewire\Component;

class PlayersRanking extends Component
{
    public $menPlayers = [];
    public $womenPlayers = [];

    public function mount()
    {
        $this->menPlayers = Player::where('gender', 'male')->get();
        $this->womenPlayers = Player::where('gender', 'female')->get();
    }

    public function render()
    {
        return view('livewire.players.players-ranking');
    }
}
