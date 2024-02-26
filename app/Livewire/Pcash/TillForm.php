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

    public  $tillAmount=[];
    public $currency_id;
    public $amount;
    public $deletedTillAmount = [];


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('till-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();


        if ($id) {
            $this->editing = true;
            $this->till = Till::findOrFail($id);

            $this->user_id = $this->till->user_id;
            $this->name = $this->till->name;

            $this->tillAmount = $this->till->tillAmount->toArray();


        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['required', 'integer'],
            'name' => ['required', 'string'],

            'tillAmount' => ['array'],
            'tillAmount.*.till_id' => ['nullable'],
            'tillAmount.*.currency_id' => ['required'],
            'tillAmount.*.amount' => ['required'], 
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->tillAmount[] = ['currency_id' => '','amount' => ''];  
    }

    public function removeTillAmount($key)
    {

        if($this->editing == true){
        $removedItemId = $this->tillAmount[$key]['id'] ?? null;
        $this->deletedTillAmount[] = $removedItemId;
        }
        unset($this->tillAmount[$key]);
        $this->tillAmount = array_values($this->tillAmount);
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
        foreach ($this->tillAmount as $tillAmount) {
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

        foreach ($this->tillAmount as $tillAmount) {
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
        $users = User::all();
        $currencies = Currency::all();

        return view('livewire.pcash.till-form',compact('users','currencies'));
    }
}
