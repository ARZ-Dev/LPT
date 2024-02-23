<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CurrencyView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->authorize('currency-delete');

        $currency = Currency::findOrFail($id);
        $currency->paymentAmount()->delete();
        $currency->receiptAmount()->delete();
        $currency->delete();

        return to_route('currency')->with('success', 'currency has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $currencies = Currency::all();
        $data['currencies'] = $currencies;

        return view('livewire.pcash.currency-view', $data);
    }
}
