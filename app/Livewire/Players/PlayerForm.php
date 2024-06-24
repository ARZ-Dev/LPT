<?php

namespace App\Livewire\Players;

use App\Models\Country;
use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Exists;
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
    public $countries = [];
    public $nationalIdFile;
    public $player;
    public bool $submitting = false;
    public array $teamPlayersIds = [];
    public $playerTeams = [];

    // form fields - start
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $current_team_id = null;
    public $birthdate = '';
    public $email = '';
    public $phone_number = '';
    public $country_id = '';
    public $nickname = '';
    public $gender = '';
    public $playing_side = '';
    public $image;
    // form fields - end

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
            $this->setPlayerData($this->player);
            $this->teamPlayersIds = $this->player->currentTeam?->players->pluck('id')->toArray() ?? [];
            $this->playerTeams = $this->player->teams;

        } else {
            $this->authorize('player-create');
        }

    }

    public function setPlayerData($player)
    {
        $this->player = $player;
        $this->first_name = $player->first_name;
        $this->middle_name = $player->middle_name;
        $this->last_name = $player->last_name;
        $this->current_team_id = $player->current_team_id;
        $this->birthdate = $player->birthdate;
        $this->email = $player->email;
        $this->phone_number = $player->phone_number;
        $this->country_id = $player->country_id;
        $this->nickname = $player->nickname;
        $this->gender = $player->gender;
        $this->playing_side = $player->playing_side;
        $this->image = $player->image;
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'max:255'],
            'middle_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'current_team_id' => ['nullable', new Exists('teams', 'id')],
            'birthdate' => ['required', 'date'],
            'email' => ['nullable', 'email'],
            'phone_number' => ['required'],
            'country_id' => ['required'],
            'nickname' => ['required'],
            'gender' => ['required', 'in:male,female'],
            'playing_side' => ['required', 'in:left,right'],
            'nationalIdFile' => ['nullable', 'max:2048'],
            'image' => ['nullable', 'max:2048']
        ];
    }

    public function store()
    {
        $this->validate();

        if($this->submitting) {
            return false;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            $path = null;
            if ($this->nationalIdFile && !is_string($this->nationalIdFile)) {
                $path = $this->nationalIdFile->storePublicly(path: 'public/national_ids');
            }

            $imagePath = null;
            if ($this->image && !is_string($this->image)) {
                $imagePath = $this->image->storePublicly(path: 'public/players/images');
            }

            $rank = Player::max('rank') + 1;

            $data = [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'current_team_id' => $this->current_team_id,
                'birthdate' => $this->birthdate,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'country_id' => $this->country_id,
                'nickname' => $this->nickname,
                'gender' => $this->gender,
                'playing_side' => $this->playing_side,
                'rank' => $rank,
            ];

            if ($path) {
                $data['national_id_upload'] = $path;
            }

            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            $player = Player::create($data);

            if ($this->current_team_id) {
                PlayerTeam::updateOrCreate([
                    'player_id' => $player->id,
                    'team_id' => $this->current_team_id,
                ],[
                    'playing_side' => $this->playing_side,
                ]);
            }

            $team = Team::findOrFail($this->current_team_id);
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

        if($this->submitting) {
            return false;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            $path = null;
            if ($this->nationalIdFile && !is_string($this->nationalIdFile)) {
                $path = $this->nationalIdFile->storePublicly(path: 'public/national_ids');
            }

            $imagePath = null;
            if ($this->image && !is_string($this->image)) {
                $imagePath = $this->image->storePublicly(path: 'public/players/images');
            }

            $data = [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'current_team_id' => $this->current_team_id,
                'birthdate' => $this->birthdate,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'country_id' => $this->country_id,
                'nickname' => $this->nickname,
                'gender' => $this->gender,
                'playing_side' => $this->playing_side,
            ];

            if ($path) {
                $data['national_id_upload'] = $path;
            }

            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            $this->player->update($data);

            if ($this->current_team_id) {
                PlayerTeam::updateOrCreate([
                    'player_id' => $this->player->id,
                    'team_id' => $this->current_team_id,
                ],[
                    'playing_side' => $this->playing_side,
                ]);

                $team = Team::findOrFail($this->current_team_id);
                $teamPlayers = $team->players()->count();

                if (!in_array($this->player->id, $this->teamPlayersIds)) {
                    throw_if($teamPlayers > 2, new \Exception($team->nickname . ' has no available spots for new players!'));
                }
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

    #[On('deleteImage')]
    public function deleteImage()
    {
        if ($this->player) {
            $this->player->image = NULL;
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

