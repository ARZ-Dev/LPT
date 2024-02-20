<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CurrencyView extends Component
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
        $this->authorize('currency-delete');

        $currency = Currency::findOrFail($id);
        $currency->delete();

        return to_route('currency')->with('success', 'currency has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $currency = Currency::all();
        $data['currency'] = $currency;

        return view('livewire.pcash.currency-view', $data);
    }
}
