<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CurrencyView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $currencies;

    public function mount(){
        $this->authorize('currency-list');
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


    // public function store(){
    //     $currencies = Currency::orderBy('list_order')->get();
    //     foreach ($currencies as $key => $currency) {
    //         Currency::create([
    //             'list_order' => $key + 1
    //         ]);
    //     }
    // }

    public function updatedCurrenciesOrder($newOrder)
    {
        foreach ($newOrder as $index => $currencyId) {
            $currency = Currency::find($currencyId);
            $currency->update(['list_order' => count($newOrder) - $index]);
        }
    }

    public function render()
    {
        $this->currencies = Currency::orderBy('list_order')->get();
        return view('livewire.pcash.currency-view');
    }
}
