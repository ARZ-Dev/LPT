<?php

namespace App\Livewire\Courts;

use App\Models\Country;
use App\Models\Court;
use Livewire\Component;

class CourtForm extends Component
{
    public bool $editing = false;
    public $countries = [];
    public $status;
    public $court;
    public $name;
    public $countryId;

    public function mount($id = 0, $status = 0)
    {
        $this->countries = Country::all();

        if ($id) {
            $this->editing = true;
            $this->court = Court::findOrFail($id);
            $this->name = $this->court->name;
            $this->countryId = $this->court->country_id;
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'countryId' => ['required'],
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'country_id' => $this->countryId,
        ];

        if ($this->editing) {
            $this->court->update($data);
        } else {
            Court::create($data);
        }

        return to_route('courts')->with('success', 'Court has been saved successfully!');
    }

    public function render()
    {
        return view('livewire.courts.court-form');
    }
}
