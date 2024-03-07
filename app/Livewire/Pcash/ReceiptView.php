<?php

namespace App\Livewire\Pcash;

use App\Models\Receipt;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class ReceiptView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $receipts;

    public function mount(){
        $this->authorize('receipt-list');
        $this->receipts = Receipt::with(['user', 'receiptAmount'])->get();

    }



    public function delete($id)
    {
        $this->authorize('receipt-delete');

        $receipt = Receipt::with('receiptAmount')->findOrFail($id);
        foreach ($receipt->receiptAmount as $receiptAmount) {

            $tillAmount = TillAmount::where('till_id', $receipt->till_id)
                ->where('currency_id', $receiptAmount->currency_id)
                ->first();

            if ($tillAmount) {
                $tillAmount->update([
                    'amount' => $tillAmount->amount - $receiptAmount->amount,
                ]);
            }

            $receiptAmount->delete();
        }
        $receipt->delete();

        return to_route('receipt')->with('success', 'receipt has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.receipt-view');
    }
}
