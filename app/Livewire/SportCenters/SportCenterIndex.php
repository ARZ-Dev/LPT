<?php

namespace App\Livewire\SportCenters;

use App\Models\Court;
use App\Models\SportCenter;
use Livewire\Attributes\On;
use Livewire\Component;

class SportCenterIndex extends Component
{
    public $sportCenters = [];

    public function mount()
    {
        $this->authorize('sportCenter-list');
        $this->sportCenters = SportCenter::with(['country', 'governorate', 'city'])->withCount('courts')->get();
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('sportCenter-delete');

        $sportCenter = SportCenter::findOrFail($id);

        $sportCenter->delete();

        return to_route('sport-centers')->with('success', 'Sport center has been deleted successfully!');
    }

    public function render()
    {
        return view('livewire.sport-centers.sport-center-index');
    }
}
