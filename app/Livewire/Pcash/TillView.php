<?php

namespace App\Livewire\Pcash;

use App\Models\Till;
use App\Models\Transfer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TillView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $tills;

    public function mount(){
        $this->tills =  Till::with(['user'])->get();
    }

    public function delete($id)
    {
        $this->authorize('till-delete');

        $till = Till::with('fromTransfer','toTransfer')->findOrFail($id);
        Transfer::Where('from_till_id',$till->id)->delete();
        Transfer::Where('to_till_id',$till->id)->delete();
        $till->delete();

        return to_route('till')->with('success', 'till has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.till-view');
    }
}
