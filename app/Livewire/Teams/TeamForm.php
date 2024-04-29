<?php

namespace App\Livewire\Teams;

use App\Models\LevelCategory;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;
use App\Utils\Constants;


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
    public $oldPlayersIds = [];
    public $team = null;
    public bool $submitting = false;

    public function mount($id = 0, $status = 0)
    {
        $this->levelCategories = LevelCategory::all();
        $this->players = Player::all();

        if ($id) {
            if ($status && $status == Constants::VIEW_STATUS) {
                $this->authorize('team-view');
            } else {
                $this->authorize('team-edit');
            }

            $this->team = Team::with('players')->findOrFail($id);
            $this->editing = true;
            $this->nickname = $this->team->nickname;
            $this->levelCategoryId = $this->team->level_category_id;
            $this->playersIds = $this->team->players->pluck('id')->toArray();
            $this->oldPlayersIds = $this->playersIds;
        } else {
            $this->authorize('team-create');
        }
    }

    public function rules()
    {
        return [
            'nickname' => ['required', 'max:255', new Unique('teams', 'id')],
            'levelCategoryId' => ['required', new Exists('level_categories', 'id')],
            'playersIds' => ['array', 'max:2']
        ];
    }

    public function store()
    {
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $team = Team::create([
            'nickname' => $this->nickname,
            'level_category_id' => $this->levelCategoryId,
        ]);

        Player::whereIn('id', $this->playersIds)->update([
            'current_team_id' => $team->id,
        ]);

        $playersData = collect();
        foreach ($this->playersIds as $playerId) {
            $playingSide = Player::find($playerId)?->playing_side;
            $playersData->put($playerId, [
                'playing_side' => $playingSide ?? ""
            ]);
        }

        $team->players()->sync($playersData);

        return to_route('teams')->with('success', 'Team has been created successfully!');
    }

    public function update()
    {
        $this->validate();

        $this->team->update([
            'nickname' => $this->nickname,
            'level_category_id' => $this->levelCategoryId,
        ]);

        Player::whereIn('id', $this->oldPlayersIds)->update([
            'current_team_id' => NULL,
        ]);

        Player::whereIn('id', $this->playersIds)->update([
            'current_team_id' => $this->team->id,
        ]);

        $playersData = collect();
        foreach ($this->playersIds as $playerId) {
            $playingSide = Player::find($playerId)?->playing_side;
            $playersData->put($playerId, [
                'playing_side' => $playingSide ?? ""
            ]);
        }

        $this->team->players()->sync($playersData);

        return to_route('teams')->with('success', 'Team has been updated successfully!');
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.teams.team-view');
        }
            return view('livewire.teams.team-form');
        }
    }

