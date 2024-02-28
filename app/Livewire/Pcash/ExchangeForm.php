<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\Exchange;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ExchangeForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $exchange;
    

    public $from_currency_id;
    public $to_currency_id;
    public $amount;
    public $rate;
    public $description;
    public $result;


    
    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('exchange-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;

        if ($id) {
            $this->editing = true;
            $this->exchange = Exchange::findOrFail($id);

            $this->from_currency_id = $this->exchange->from_currency_id;
            $this->to_currency_id = $this->exchange->to_currency_id;
            $this->amount = $this->exchange->amount;
            $this->rate = $this->exchange->rate;
            $this->description = $this->exchange->description;
            $this->result = $this->exchange->result;

        }

    }

    protected function rules()
    {
        $rules = [
            'from_currency_id' => ['required', 'integer'],
            'to_currency_id' => ['required', 'integer'],
            'amount' => ['required'],
            'rate' => ['required'],
            'description' => ['nullable', 'string'],
            'result' => ['nullable'],

        ];

        return $rules;
    }

    private function sanitizeNumber($number)
    {
        $number = str_replace(',', '', $number);
        if (substr($number, -1) === '.') {
            $number = substr($number, 0, -1);
        }

        return $number;
    }

    public function store()
    {
    $this->authorize('exchange-edit');

    $this->validate();

    Exchange::create([
        'from_currency_id' => $this->from_currency_id ,
        'to_currency_id' => $this->to_currency_id ,
        'amount' => $this->sanitizeNumber($this->amount) ,
        'rate' => $this->sanitizeNumber($this->rate) ,
        'description' => $this->description ,
        'result' => $this->sanitizeNumber($this->result) ,


    ]);


    session()->flash('success', 'exchange has been created successfully!');

    return redirect()->route('exchange');
}


    public function update()
    {
        $this->authorize('exchange-edit');

        $this->validate();

        $this->exchange->update([
            'from_currency_id' => $this->from_currency_id ,
            'to_currency_id' => $this->to_currency_id ,
            'amount' => $this->sanitizeNumber($this->amount),
            'rate' => $this->sanitizeNumber($this->rate),
            'description' => $this->description ,
            'result' => $this->sanitizeNumber($this->result),

        ]);

        session()->flash('success', 'exchange has been updated successfully!');

        return redirect()->route('exchange');
    }
    

    public function render()
    {
        $currencies = Currency::all();
        return view('livewire.pcash.exchange-form',compact('currencies'));
    }
}
