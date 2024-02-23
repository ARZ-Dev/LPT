<?php

namespace App\Livewire\Forms;

use App\Models\Player;
use Illuminate\Validation\Rules\Exists;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PlayerFormData extends Form
{
    public ?Player $player;

    #[Validate('required|max:255')]
    public string $firstName = '';

    #[Validate('required|max:255')]
    public string $middleName = '';

    #[Validate('required|max:255')]
    public string $lastName = '';

    #[Validate(['nullable', new Exists('teams', 'id')])]
    public $teamId = null;

    #[Validate('required|date')]
    public string $birthdate = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $phoneNumber = '';

    #[Validate('required')]
    public $countryId = null;

    #[Validate('required')]
    public string $nickname = '';

    #[Validate('required')]
    public string $playingSide = '';

    public function setPlayer(Player $player): void
    {
        $this->player = $player;
        $this->firstName = $player->first_name;
        $this->middleName = $player->middle_name;
        $this->lastName = $player->last_name;
    }
}
