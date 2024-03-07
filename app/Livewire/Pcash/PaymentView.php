<?php

namespace App\Livewire\Pcash;

use App\Models\Payment;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class PaymentView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $payments;

    public function mount()
    {
        $this->authorize('payment-list');
        $this->payments = Payment::with(['category', 'subCategory'])->get();
    }

    public function delete($id)
    {
        $this->authorize('payment-delete');

        $payment = Payment::with('paymentAmounts')->findOrFail($id);
        foreach ($payment->paymentAmounts as $paymentAmount) {

            $tillAmount = TillAmount::where('till_id', $payment->till_id)
                ->where('currency_id', $paymentAmount->currency_id)
                ->first();

            if ($tillAmount) {
                $tillAmount->update([
                    'amount' => $tillAmount->amount + $paymentAmount->amount,
                ]);
            }

            $paymentAmount->delete();
        }

        $payment->delete();

        return to_route('payment')->with('success', 'Payment has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.payment-view');
    }
}
