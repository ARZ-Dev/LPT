<?php

namespace App\Livewire\Pcash;

use App\Models\Receipt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class ReceiptView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];



    public function delete($id)
    {
        $this->authorize('receipt-delete');

        $receipt = Receipt::findOrFail($id);
        $receipt->receiptAmount()->delete();
        $receipt->delete();

        return to_route('receipt')->with('success', 'receipt has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $receipts = Receipt::with(['user', 'receiptAmount'])->get();

        $data['receipts'] = $receipts;
        

        return view('livewire.pcash.receipt-view', $data);
    }
}
