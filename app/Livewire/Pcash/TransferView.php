<?php

namespace App\Livewire\Pcash;

use App\Models\Transfer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TransferView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['deleteConfirm','delete'];

    public function deleteConfirm($method, $id = null): void
    {
        $this->dispatch('swal:confirm', [
            'type'  => 'warning',
            'title' => 'Are you sure?',
            'text'  => 'You won\'t be able to revert this!',
            'id'    => $id,
            'method' => $method,
        ]);
    }

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


        $transfer = Transfer::with(['fromTill','toTill'])->get();


        // dd($transfer);

        $data['transfer'] = $transfer;

        return view('livewire.pcash.transfer-view', $data);
    }
}
