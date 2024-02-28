<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CurrencyForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $currency;
    

    public $name;
    public $symbol;
    
    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('currency-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;

        if ($id) {
            $this->editing = true;
            $this->currency = Currency::findOrFail($id);

            $this->name = $this->currency->name;
            $this->symbol = $this->currency->symbol;

        }

    }

    protected function rules()
    {
        $rules = [
            'name' => ['required', 'string'],
            'symbol' => ['required', 'string'],

        ];

        return $rules;
    }

    public function store()
    {
    $this->authorize('currency-edit');

    $this->validate();

    Currency::create([
        'name' => $this->name ,
        'symbol' => $this->symbol ,

    ]);


    session()->flash('success', 'currency has been created successfully!');

    return redirect()->route('currency');
}


    public function update()
    {
        $this->authorize('currency-edit');

        $this->validate();

        $this->currency->update([
            'name' => $this->name ,
            'symbol' => $this->symbol ,
    

        ]);

        session()->flash('success', 'currency has been updated successfully!');

        return redirect()->route('currency');
    }
    

    public function render()
    {
        return view('livewire.pcash.currency-form');
    }
}
