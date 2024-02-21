<?php

namespace App\Livewire\Pcash;

use App\Models\Payment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class PaymentView extends Component
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
        $this->authorize('payment-delete');

        $payment = Payment::findOrFail($id);
        $payment->delete();

        return to_route('payment')->with('success', 'payment has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $payment = Payment::with(['category', 'subCategory', 'paymentAmount'])->get();

        $data['payment'] = $payment;
        

        return view('livewire.pcash.payment-view', $data);
    }
}
