<?php

namespace App\Livewire\Courts;

use App\Models\Country;
use App\Models\Court;
use App\Models\Governorate;
use Livewire\Attributes\On;
use Livewire\Component;

class CourtForm extends Component
{
    public bool $editing = false;
    public $countries = [];
    public $governorates = [];
    public $status;
    public $court;
    public $name;
    public $countryId;
    public $governorateId;

    public function mount($id = 0, $status = 0)
    {
        $this->countries = Country::all();

        if ($id) {
            $this->editing = true;
            $this->court = Court::findOrFail($id);
            $this->name = $this->court->name;
            $this->countryId = $this->court->country_id;
            $this->getGovernorates();
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'countryId' => ['required'],
            'governorateId' => ['required'],
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'country_id' => $this->countryId,
            'governorate_id' => $this->governorateId,
        ];

        if ($this->editing) {
            $this->court->update($data);
        } else {
            Court::create($data);
        }

        return to_route('courts')->with('success', 'Court has been saved successfully!');
    }

    #[On('getGovernorates')]
    public function getGovernorates()
    {
        $this->governorateId = null;
        $this->governorates = Governorate::where('country_id', $this->countryId)->get();
        $selectedGovernorateId = null;
        if ($this->court) {
            $selectedGovernorateId = $this->court?->governorate_id;
        } else {
            if (count($this->governorates) == 1) {
                $selectedGovernorateId = $this->governorates[0]->id;
                $this->governorateId = $selectedGovernorateId;
            }
        }
        $this->dispatch('refreshGovernorates', $this->governorates, $selectedGovernorateId);
    }

    public function render()
    {
        return view('livewire.courts.court-form');
    }
}
