<?php

namespace App\Livewire\Pcash;

use App\Models\Till;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TillView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->authorize('till-delete');

        $till = Till::findOrFail($id);
        $till->fromTransfer()->delete();
        $till->toTransfer()->delete();
        $till->delete();

        return to_route('till')->with('success', 'till has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $tills = Till::with(['user'])->get();
        $data['tills'] = $tills;

        return view('livewire.pcash.till-view', $data);
    }
}
