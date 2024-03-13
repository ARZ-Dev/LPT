<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CurrencyView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete', 'updateOrder'];
    public $currencies;

    public function mount(){
        $this->authorize('currency-list');
        $this->currencies = Currency::orderBy('list_order')->OrderBy('list_order')->get();
    }

    public function delete($id)
    {
        $this->authorize('currency-delete');

        $currency = Currency::with('paymentAmount','receiptAmount')->findOrFail($id);
        $currency->paymentAmount()->delete();
        $currency->receiptAmount()->delete();
        $currency->delete();

        return to_route('currency')->with('success', 'currency has been deleted successfully!');
    }

    public function updateOrder($currenciesOrder)
    {
        foreach ($currenciesOrder as $index => $currencyId) {
            $currency = Currency::find($currencyId);
            $currency->update([
                'list_order' => $index + 1,
            ]);
        }

        $this->currencies = Currency::orderBy('list_order')->OrderBy('list_order')->get();

        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text'  => "Currencies order has been updated successfully!",
        ]);
    }

    public function render()
    {
        return view('livewire.pcash.currency.currency-index');
    }
}
