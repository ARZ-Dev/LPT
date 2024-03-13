<?php

namespace App\Livewire\Forms;

use App\Models\Player;
use App\Models\PlayerTeam;
use Illuminate\Validation\Rules\Exists;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PlayerFormData extends Form
{
    public ?Player $player;

    #[Validate('required|max:255')]
    public string $first_name = '';

    #[Validate('required|max:255')]
    public string $middle_name = '';

    #[Validate('required|max:255')]
    public string $last_name = '';

    #[Validate(['nullable', new Exists('teams', 'id')])]
    public $current_team_id = null;

    #[Validate('required|date')]
    public string $birthdate = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $phone_number = '';

    #[Validate('required')]
    public $country_id = '';

    #[Validate('required')]
    public string $nickname = '';

    #[Validate('required')]
    public string $playing_side = '';

    public function setPlayer(Player $player): void
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
        $this->playing_side = $player->playing_side;
    }

    public function store($path)
    {
        $data = $this->except('player');

        if ($path) {
            $data['national_id_upload'] = $path;
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
    }

    public function update($path)
    {
        $data = $this->except('player');

        if ($path) {
            $data['national_id_upload'] = $path;
        }

        $this->player->update($data);

        if ($this->current_team_id) {
            PlayerTeam::updateOrCreate([
                'player_id' => $this->player->id,
                'team_id' => $this->current_team_id,
            ],[
                'playing_side' => $this->playing_side,
            ]);
        }
    }
}
