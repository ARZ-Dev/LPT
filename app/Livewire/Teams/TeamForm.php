<?php

namespace App\Livewire\Teams;

use App\Models\LevelCategory;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class TeamForm extends Component
{
    use AuthorizesRequests;

    public bool $editing = false;
    public int $status = 0;
    public $levelCategories = [];
    public $players = [];

    public string $nickname = "";
    public $levelCategoryId = null;
    public $playersIds = [];
    public $team = null;

    public function mount($id = 0, $status = 0)
    {
        $this->levelCategories = LevelCategory::all();
        $this->players = Player::all();

        if ($id) {
            $this->authorize('team-edit');
            $this->team = Team::with('players')->findOrFail($id);
            $this->editing = true;
            $this->nickname = $this->team->nickname;
            $this->levelCategoryId = $this->team->level_category_id;
            $this->playersIds = $this->team->players->pluck('id')->toArray();
        } else {
            $this->authorize('team-create');
        }
    }

    public function rules()
    {
        return [
            'nickname' => ['required', 'max:255', new Unique('teams', 'id')],
            'levelCategoryId' => ['required', new Exists('level_categories', 'id')],
            'playersIds' => ['array']
        ];
    }

    public function store()
    {
        $this->validate();

        $team = Team::create([
            'nickname' => $this->nickname,
            'level_category_id' => $this->levelCategoryId,
        ]);

        Player::whereIn('id', $this->playersIds)->update([
            'team_id' => $team->id,
        ]);

        return to_route('teams')->with('success', 'Team has been created successfully!');
    }

    public function update()
    {
        $this->validate();

        $this->team->update([
            'nickname' => $this->nickname,
            'level_category_id' => $this->levelCategoryId,
        ]);

        Player::whereIn('id', $this->playersIds)->update([
            'team_id' => $this->team->id,
        ]);

        return to_route('teams')->with('success', 'Team has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.teams.team-form');
    }
}
