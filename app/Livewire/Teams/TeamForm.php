<?php

namespace App\Livewire\Teams;

use App\Livewire\Matches\MatchesView;
use App\Models\LevelCategory;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Utils\Constants;
use Livewire\WithFileUploads;


class TeamForm extends Component
{
    use AuthorizesRequests, WithFileUploads;

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
    public $image;

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
            $this->image = $this->team->image;
        } else {
            $this->authorize('team-create');
        }
    }

    public function rules()
    {
        return [
            'nickname' => ['required', 'max:255', new Unique('teams', 'id')],
            'levelCategoryId' => ['required', new Exists('level_categories', 'id')],
            'playersIds' => ['array', 'max:2'],
            'image' => ['nullable', 'max:2048'],
        ];
    }

    public function store()
    {
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $path = null;
        if ($this->image && !is_string($this->image)) {
            $path = $this->image->storePublicly(path: 'public/teams/images');
        }

        $rank = Team::where('level_category_id', $this->levelCategoryId)->max('rank') + 1;
        $team = Team::create([
            'nickname' => $this->nickname,
            'level_category_id' => $this->levelCategoryId,
            'rank' => $rank,
            'image' => $path,
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

        $data = [
            'nickname' => $this->nickname,
            'level_category_id' => $this->levelCategoryId,
        ];

        if ($this->image && !is_string($this->image)) {
            $data['image'] = $this->image->storePublicly(path: 'public/teams/images');
        }

        $oldCategoryId = $this->team->level_category_id;
        $shouldRefreshRanks = $this->team->level_category_id != $this->levelCategoryId;

        $this->team->update($data);

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

        if ($shouldRefreshRanks) {
            MatchesView::updateTeamsRank($oldCategoryId);
            MatchesView::updateTeamsRank($this->levelCategoryId);
        }

        return to_route('teams')->with('success', 'Team has been updated successfully!');
    }

    #[On('deleteImage')]
    public function deleteImage()
    {
        if ($this->team) {
            $this->team->image = NULL;
            $this->team->save();
        }
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.teams.team-view');
        }
            return view('livewire.teams.team-form');
        }
    }

