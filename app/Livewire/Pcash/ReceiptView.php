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

    public function mount()
    {
        $this->authorize('receipt-list');
        $this->receipts = Receipt::with(['user', 'category', 'subCategory'])
            ->when(!auth()->user()->hasPermissionTo('receipt-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')->get();
    }

    public function delete($id)
    {
        $this->authorize('receipt-delete');

        $receipt = Receipt::with('receiptAmounts')->findOrFail($id);
        foreach ($receipt->receiptAmounts as $receiptAmount) {

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

        return to_route('receipt')->with('success', 'Receipt has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.receipt.receipt-index');
    }
}
