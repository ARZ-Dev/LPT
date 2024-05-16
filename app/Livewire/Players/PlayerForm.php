<?php

namespace App\Livewire\Players;

use App\Livewire\Forms\PlayerFormData;
use App\Models\Country;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Utils\Constants;


class PlayerForm extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public bool $editing = false;
    public int $status = 0;
    public $teams = [];
    public PlayerFormData $form;
    public $countries = [];
    public $nationalIdFile;
    public $player;
    public bool $submitting = false;
    public array $teamPlayersIds = [];
    public $playerTeams = [];

    public function mount($id = 0, $status = 0)
    {
        $this->teams = Team::all();
        $this->countries = Country::all();
        $this->status = $status;

        if ($id) {

            if ($status && $status == Constants::VIEW_STATUS) {
                $this->authorize('player-view');
            } else {
                $this->authorize('player-edit');
            }

            $this->player = Player::with(['teams' => ['levelCategory', 'players']])->findOrFail($id);
            $this->editing = true;
            $this->form->setPlayer($this->player);
            $this->teamPlayersIds = $this->player->currentTeam?->players->pluck('id')->toArray() ?? [];
            $this->playerTeams = $this->player->teams;

        } else {
            $this->authorize('player-create');
        }

    }

    public function store()
    {
        $this->validate();

        $this->validate([
            'nationalIdFile' => ['nullable', 'file', 'max:2048']
        ]);

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            $path = null;
            if ($this->nationalIdFile && !is_string($this->nationalIdFile)) {
                $path = $this->nationalIdFile->storePublicly(path: 'public/national_ids');
            }

            $this->form->store($path);

            $team = Team::findOrFail($this->form->current_team_id);
            $teamPlayers = $team->players()->count();
            throw_if($teamPlayers > 2, new \Exception($team->nickname . ' has no available spots for new players!'));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->submitting = false;

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }


        return to_route('players')->with('success', 'Player has been added successfully!');
    }

    public function update()
    {
        $this->validate();

        $this->validate([
            'nationalIdFile' => ['nullable', 'file', 'max:2048']
        ]);

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            $path = null;
            if ($this->nationalIdFile && !is_string($this->nationalIdFile)) {
                $path = $this->nationalIdFile->storePublicly(path: 'public/national_ids');
            }

            $this->form->update($path);

            $team = Team::findOrFail($this->form->current_team_id);
            $teamPlayers = $team->players()->count();

            if (!in_array($this->player->id, $this->teamPlayersIds)) {
                throw_if($teamPlayers > 2, new \Exception($team->nickname . ' has no available spots for new players!'));
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            $this->submitting = false;

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('players')->with('success', 'Player has been updated successfully!');
    }

    #[On('deleteNationalIdFile')]
    public function deleteNationalIdFile()
    {
        if ($this->player) {
            $this->player->national_id_upload = NULL;
            $this->player->save();
        }
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.players.player-view');
        }
        return view('livewire.players.player-form');
    }
}

