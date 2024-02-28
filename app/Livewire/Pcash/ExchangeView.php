<?php

namespace App\Livewire\Pcash;

use App\Models\Exchange;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class ExchangeView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];

    public function delete($id)
    {
        $this->authorize('exchange-delete');

        $exchange = Exchange::with('currency')->findOrFail($id);

        $exchange->delete();

        return to_route('exchange')->with('success', 'exchange has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $exchanges = Exchange::with('fromCurrency','toCurrency')->get();
        $data['exchanges'] = $exchanges;

        // dd($exchanges);

        return view('livewire.pcash.exchange-view', $data);
    }
}
