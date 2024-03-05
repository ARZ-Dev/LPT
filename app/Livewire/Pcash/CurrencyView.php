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
        $this->currencies = Currency::all();

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

    public function store(){
        $currencies = Currency::orderBy('list_order')->get();
    
        foreach ($currencies as $index => $currency) {
            $currency->list_order = $index + 1;
            $currency->save();
        }
    }


    public function render()
    {
        return view('livewire.pcash.currency-view');
    }
}
