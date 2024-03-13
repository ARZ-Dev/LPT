<?php

namespace App\Livewire\Pcash;

use App\Models\Exchange;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class ExchangeView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $exchanges;

    public function mount()
    {
        $this->authorize('exchange-list');
        $this->exchanges = Exchange::with('fromCurrency','toCurrency')
            ->when(!auth()->user()->hasPermissionTo('exchange-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();
    }

    public function delete($id)
    {
        $this->authorize('exchange-delete');

        $exchange = Exchange::findOrFail($id);

        $fromTillAmount = TillAmount::where('till_id', $exchange->till_id)->where('currency_id', $exchange->from_currency_id)->first();
        $toTillAmount = TillAmount::where('till_id', $exchange->till_id)->where('currency_id', $exchange->to_currency_id)->first();

        if ($fromTillAmount) {
            $fromTillAmount->update([
                'amount' => $fromTillAmount->amount - $exchange->amount,
            ]);
        }

        if ($toTillAmount) {
            $toTillAmount->update([
                'amount' => $toTillAmount->amount + $exchange->result,
            ]);
        }

        $exchange->delete();

        return to_route('exchange')->with('success', 'Exchange has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.exchange.exchange-index');
    }
}
