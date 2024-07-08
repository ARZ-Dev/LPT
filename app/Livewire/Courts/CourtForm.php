<?php

namespace App\Livewire\Courts;

use App\Models\City;
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
    public $cities = [];
    public $status;
    public $court;
    public $name;
    public $countryId;
    public $governorateId;
    public $cityId;

    public function mount($id = 0, $status = 0)
    {
        $this->countries = Country::all();

        if ($id) {
            $this->editing = true;
            $this->court = Court::findOrFail($id);
            $this->name = $this->court->name;
            $this->countryId = $this->court->country_id;
            $this->governorateId = $this->court->governorate_id;
            $this->cityId = $this->court->city_id;
            $this->getGovernorates();
            $this->getCities();
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'countryId' => ['required'],
            'governorateId' => ['required'],
            'cityId' => ['required'],
        ];
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'country_id' => $this->countryId,
            'governorate_id' => $this->governorateId,
            'city_id' => $this->cityId,
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

    #[On('getCities')]
    public function getCities()
    {
        $this->cities = City::where('governorate_id', $this->governorateId)->get();
        $selectedCityId = null;
        if ($this->court) {
            $selectedCityId = $this->court?->city_id;
        } else {
            if (count($this->cities) == 1) {
                $selectedCityId = $this->cities[0]->id;
                $this->cityId = $selectedCityId;
            }
        }
        $this->dispatch('refreshCities', $this->cities, $selectedCityId);
    }

    public function render()
    {
        return view('livewire.courts.court-form');
    }
}
