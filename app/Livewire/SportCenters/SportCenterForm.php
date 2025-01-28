<?php

namespace App\Livewire\SportCenters;

use App\Models\City;
use App\Models\Country;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\SportCenter;
use Livewire\Attributes\On;
use Livewire\Component;

class SportCenterForm extends Component
{
    public bool $editing = false;
    public $countries = [];
    public $governorates = [];
    public $cities = [];
    public $status;
    public $sportCenter;
    public $name;
    public $countryId;
    public $governorateId;
    public $cityId;
    public $courts = [];

    public function mount($id = 0, $status = 0)
    {
        $this->countries = Country::all();

        if ($id) {
            $this->editing = true;
            $this->sportCenter = SportCenter::with(['courts'])->findOrFail($id);
            $this->name = $this->sportCenter->name;
            $this->countryId = $this->sportCenter->country_id;
            $this->governorateId = $this->sportCenter->governorate_id;
            $this->cityId = $this->sportCenter->city_id;
            $this->getGovernorates();
            $this->getCities();

            if (count($this->sportCenter->courts)) {
                foreach ($this->sportCenter->courts as $court) {
                    $this->courts[] = [
                        'id' => $court->id,
                        'name' => $court->name,
                    ];
                }
            }
        }
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'countryId' => ['required'],
            'governorateId' => ['required'],
            'cityId' => ['required'],
            'courts.*.name' => ['required', 'max:255']
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
            $this->sportCenter->update($data);
        } else {
            $this->sportCenter = SportCenter::create($data);
        }

        $courtsIds = [];
        foreach ($this->courts as $court) {
            $createdCourt = $this->sportCenter->courts()->updateOrCreate([
                'id' => $court['id'] ?? 0,
            ],[
                'name' => $court['name']
            ]);
            $courtsIds[] = $createdCourt->id;
        }
        $this->sportCenter->courts()->whereNotIn('id', $courtsIds)->delete();

        return to_route('sport-centers')->with('success', 'Sport center has been saved successfully!');
    }

    public function addCourt()
    {
        $this->courts[] = [
            'name' => ''
        ];
    }

    public function removeCourt($index)
    {
        unset($this->courts[$index]);
        $this->courts = array_values($this->courts);
    }

    #[On('getGovernorates')]
    public function getGovernorates()
    {
        $this->governorates = Governorate::where('country_id', $this->countryId)->get();
        $selectedGovernorateId = null;
        if ($this->sportCenter) {
            $selectedGovernorateId = $this->sportCenter?->governorate_id;
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
        if ($this->sportCenter) {
            $selectedCityId = $this->sportCenter?->city_id;
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
        return view('livewire.sport-centers.sport-center-form');
    }
}
