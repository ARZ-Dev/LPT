<?php

namespace App\Livewire\Courts;

use App\Models\Court;
use Livewire\Attributes\On;
use Livewire\Component;

class CourtIndex extends Component
{
    public $courts = [];


    public function mount()
    {
        $this->authorize('court-list');
        $this->courts = Court::with('country')->get();
    }

    #[On('delete')]
    public function delete($id)
    {
        $this->authorize('court-delete');

        $court = Court::findOrFail($id);

        $court->delete();

        return to_route('courts')->with('success', 'Court has been deleted successfully!');
    }

    public function render()
    {
        return view('livewire.courts.court-index');
    }
}
