<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Utils\Constants;

class CurrencyForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $currency;


    public $user_id;
    public $name;
    public $symbol;
    public bool $submitting = false;
    public bool $isDefaultCurrency = false;
    public $defaultCurrency;
    public $rate;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('currency-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status = $status;
        $this->defaultCurrency = Currency::where('is_default', true)->first();

        if ($id) {
            $this->editing = true;
            $this->currency = Currency::With('user')->findOrFail($id);
            $this->isDefaultCurrency = $this->defaultCurrency?->id == $id;

            $this->user_id = $this->currency->user_id;
            $this->name = $this->currency->name;
            $this->symbol = $this->currency->symbol;
            $this->rate = $this->currency->rate;
        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['nullable'],
            'name' => ['required', 'string'],
            'symbol' => ['required', 'string'],
            'rate' => [new RequiredIf(!$this->isDefaultCurrency)]
        ];

        return $rules;
    }

    public function store()
    {
    $this->authorize('currency-edit');

    $this->validate();

    if($this->submitting) {
        return;
    }
    $this->submitting = true;

    Currency::create([
        'user_id' => auth()->id() ,
        'name' => $this->name ,
        'symbol' => $this->symbol ,
        'list_order' => Currency::max('list_order') + 1,
        'rate' => sanitizeNumber($this->rate),
    ]);

    session()->flash('success', 'currency has been created successfully!');

    return redirect()->route('currency');
}


    public function update()
    {
        $this->authorize('currency-edit');

        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $this->currency->update([
            'name' => $this->name,
            'symbol' => $this->symbol,
            'rate' => sanitizeNumber($this->rate),
        ]);

        session()->flash('success', 'currency has been updated successfully!');

        return redirect()->route('currency');
    }


    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.currency.currency-view');
        }
            return view('livewire.pcash.currency.currency-form');
    }
}

