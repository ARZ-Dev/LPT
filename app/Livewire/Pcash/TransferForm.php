<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\till;
use App\Models\Transfer;
use App\Models\TransferAmount;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class TransferForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $transfer;

    public $from_till_id;
    public $to_till_id;

    public  $transferAmount=[];
    public $currency_id;
    public $amount;
    public $deletedTransferAmount = [];

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('transfer-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();


        if ($id) {
            $this->editing = true;
            $this->transfer = Transfer::findOrFail($id);

            $this->from_till_id = $this->transfer->from_till_id;
            $this->to_till_id = $this->transfer->to_till_id;
            $this->transferAmount = $this->transfer->transferAmount->toArray();


        }

    }

    protected function rules()
    {
        $rules = [
            'from_till_id' => ['required', 'integer'],
            'to_till_id' => ['required', 'integer'],

            'transferAmount' => ['array'],
            'transferAmount.*.transfer_id' => ['nullable'],
            'transferAmount.*.currency_id' => ['required'],
            'transferAmount.*.amount' => ['required'], 
        ];

        return $rules;
    }
    public function addRow()
    {
        $this->transferAmount[] = ['currency_id' => '','amount' => ''];  
    }

    public function removeTransferAmount($key)
    {

      
        if($this->editing == true){
        $removedItemId = $this->transferAmount[$key]['id'] ?? null ;
        $this->deletedTransferAmount[] = $removedItemId;
        }

        unset($this->transferAmount[$key]);
        $this->transferAmount = array_values($this->transferAmount);
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
    $this->authorize('transfer-edit');

    $this->validate();

    $transfer=Transfer::create([
        'from_till_id' => $this->from_till_id ,
        'to_till_id' => $this->to_till_id ,

    ]);

    $transferId = $transfer->id;
    foreach ($this->transferAmount as $transferAmount) {
        TransferAmount::create([
            'transfer_id' => $transferId,
            'currency_id' => $transferAmount['currency_id'],
            'amount' => $this->sanitizeNumber($transferAmount['amount']),
        ]);
    }


    session()->flash('success', 'transfer has been created successfully!');

    return redirect()->route('transfer');
}



    public function update()
    {
        $this->authorize('transfer-edit');

        $this->validate();

        $this->transfer->update([
            'from_till_id' => $this->from_till_id ,
            'to_till_id' => $this->to_till_id ,
        ]);

        foreach ($this->transferAmount as $transferAmount) {
            $data = [
                'transfer_id' => $this->transfer->id,
                'currency_id' => $transferAmount['currency_id'],
                'amount' => $this->sanitizeNumber($transferAmount['amount']),
            ];
        
            if (isset($transferAmount['id'])) {
                TransferAmount::updateOrCreate(['id' => $transferAmount['id']], $data);
            } else {
                TransferAmount::create($data);
            }
        }

        TransferAmount::whereIn('id',$this->deletedTransferAmount)->delete();

        session()->flash('success', 'transfer has been updated successfully!');

        return redirect()->route('transfer');
    }
    



    public function render()
    {
        $fromTills = Till::where('user_id',auth()->id())->get();
        $toTills = Till::where('user_id', '<>', auth()->id())->get();
        $currencies = Currency::all();


        return view('livewire.pcash.transfer-form',compact('fromTills','toTills','currencies'));
    }
}
