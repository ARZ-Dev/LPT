<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use Livewire\Component;

class TeamView extends Component
{
    public $teams = [];

    protected $listeners = [
        'delete'
    ];
    public function mount()
    {
        $this->teams = Team::all();
    }

    public function delete($id)
    {
        $team = Team::with('players')->find($id);

        $team->players()->update([
            'team_id' => NULL,
        ]);

        $team->delete();

        return to_route('teams')->with('success', 'Team has been deleted successfully!');
    }

    public function render()
    {
        return view('livewire.teams.team-view');
    }
}