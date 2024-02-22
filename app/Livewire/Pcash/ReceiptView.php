<?php

namespace App\Livewire\Pcash;

use App\Models\Receipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class ReceiptView extends Component
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
        $this->authorize('receipt-delete');

        $receipt = Receipt::findOrFail($id);
        $receipt->delete();

        return to_route('receipt')->with('success', 'receipt has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $receipt = Receipt::with(['user', 'receiptAmount'])->get();

        $data['receipt'] = $receipt;
        

        return view('livewire.pcash.receipt-view', $data);
    }
}
