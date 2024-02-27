<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class TillForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;
    public $roles;
    public $till;
    public $user_id;
    public $name;
    public $tillAmounts=[];
    public $currency_id;
    public $amount;
    public $deletedTillAmount = [];
    public $selectedCurrencies = [];
    public $users = [];
    public $currencies = [];

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('till-list');

        $this->users = User::all();
        $this->currencies = Currency::all();
        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();

        if ($id) {
            $this->editing = true;
            $this->till = Till::findOrFail($id);

            $this->user_id = $this->till->user_id;
            $this->name = $this->till->name;

            $this->tillAmounts = $this->till->tillAmount->toArray();
        }

    }

    public function checkCurrencies($value) {
        $this->selectedCurrencies[] = $value;
    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['required', 'integer'],
            'name' => ['required', 'string'],

            'tillAmounts' => ['array'],
            'tillAmounts.*.till_id' => ['nullable'],
            'tillAmounts.*.currency_id' => ['required'],
            'tillAmounts.*.amount' => ['required'],
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->tillAmounts[] = [
            'amount' => '',
            'currency_id' => '',
        ];
        $this->dispatch('triggerLibraries');
    }

    public function removeRow($key)
    {
        $index = array_search($this->tillAmounts[$key]['currency_id'], $this->selectedCurrencies);
        if ($index !== false) {
            unset($this->selectedCurrencies[$index]);
        }

        if($this->editing == true){
        $removedItemId = $this->tillAmounts[$key]['id'] ?? null;
        $this->deletedTillAmount[] = $removedItemId;
        }
        unset($this->tillAmounts[$key]);
        $this->tillAmounts = array_values($this->tillAmounts);

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
        $this->authorize('till-edit');

        $this->validate();

        $till=Till::create([
            'user_id' => $this->user_id ,
            'name' => $this->name ,
        ]);

        $tillId = $till->id;
        foreach ($this->tillAmounts as $tillAmount) {
            TillAmount::create([
                'till_id' => $tillId,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => $this->sanitizeNumber($tillAmount['amount']),
            ]);
        }

        session()->flash('success', 'till has been created successfully!');

        return redirect()->route('till');
    }





    public function update()
    {
        $this->authorize('till-edit');

        $this->validate();

        $this->till->update([
            'user_id' => $this->user_id ,
            'name' => $this->name ,


        ]);

        foreach ($this->tillAmounts as $tillAmount) {
            $data = [
                'till_id' => $this->till->id,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => $this->sanitizeNumber($tillAmount['amount']),
            ];

            if (isset($tillAmount['id'])) {
                TillAmount::updateOrCreate(['id' => $tillAmount['id']], $data);
            } else {
                TillAmount::create($data);
            }
        }

        TillAmount::whereIn('id',$this->deletedTillAmount)->delete();

        session()->flash('success', 'till has been updated successfully!');

        return redirect()->route('till');
    }




    public function render()
    {

        return view('livewire.pcash.till-form');
    }
}
