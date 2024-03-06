<?php

namespace App\Livewire\Pcash;

use App\Models\Payment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class PaymentView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $payments;

    public function mount(){
        $this->authorize('payment-list');
        $this->payments = Payment::with(['category', 'subCategory', 'paymentAmount','till'])->get();

    }

    public function delete($id)
    {
        $this->authorize('payment-delete');

        $payment = Payment::with('paymentAmount')->findOrFail($id);
        $payment->paymentAmount()->delete();

        $payment->delete();

        return to_route('payment')->with('success', 'payment has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.payment-view');
    }
}
