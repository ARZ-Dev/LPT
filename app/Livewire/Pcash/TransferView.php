<?php

namespace App\Livewire\Pcash;

use App\Models\Transfer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TransferView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->authorize('transfer-delete');

        $transfer = Transfer::findOrFail($id);
        $transfer->delete();

        return to_route('transfer')->with('success', 'transfer has been deleted successfully!');
    }


    public function render()
    {
        $data = [];


        $transfers = Transfer::with(['fromTill.user','toTill'])->get();

        $data['transfers'] = $transfers;

        return view('livewire.pcash.transfer-view', $data);
    }
}