<?php

namespace App\Livewire\Pcash;


use App\Models\Currency;
use App\Models\Receipt;
use App\Models\ReceiptAmount;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ReceiptForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $receipt;

    public $user_id;
    public $paid_by;
    public $description;

    public  $receiptAmount=[];
    public $receipt_id;
    public $currency_id;
    public $amount;

    public $deletedReceiptAmount = [];


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('receipt-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();

        if ($id) {
            $this->editing = true;
            $this->receipt = Receipt::with('receiptAmount')->findOrFail($id);

            $this->paid_by = $this->receipt->paid_by;
            $this->description = $this->receipt->description;
            $this->receiptAmount = $this->receipt->receiptAmount->toArray();
            
        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['nullable'],
            'paid_by' => ['required', 'string'],
            'description' => ['nullable', 'string'],

            'receiptAmount' => ['array'],
            'receiptAmount.*.receipt_id' => ['nullable'],
            'receiptAmount.*.currency_id' => ['required'],
            'receiptAmount.*.amount' => ['required'],  
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->receiptAmount[] = ['currency_id' => '','amount' => ''];  
    }

    public function removeReceiptAmount($key)
    {
        if($this->editing == true){
            $removedItemId = $this->receiptAmount[$key]['id'] ?? null;
            $this->deletedReceiptAmount[] = $removedItemId;
        }
        unset($this->receiptAmount[$key]);
        $this->receiptAmount = array_values($this->receiptAmount);
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
    $this->authorize('receipt-edit');

    $this->validate();

   
    $receipt=Receipt::create([
        'user_id' => auth()->id(),
        'paid_by' => $this->paid_by ,
        'description' => $this->description ,
    ]);

    $receiptId = $receipt->id;
    foreach ($this->receiptAmount as $receiptAmount) {
        ReceiptAmount::create([
            'receipt_id' => $receiptId,
            'currency_id' => $receiptAmount['currency_id'],
            'amount' => $this->sanitizeNumber($receiptAmount['amount']),
        ]);
    }


    session()->flash('success', 'receipt has been created successfully!');

    return redirect()->route('receipt');
}


    public function update()
    {
        $this->authorize('receipt-edit');

        $this->validate();

        $this->receipt->update([
            'user_id' => auth()->id() ,
            'paid_by' => $this->paid_by ,
            'description' => $this->description ,
        ]);

        foreach ($this->receiptAmount as $receiptAmount) {
            $data = [
                'receipt_id' => $this->receipt->id,
                'currency_id' => $receiptAmount['currency_id'],
                'amount' => $this->sanitizeNumber($receiptAmount['amount']),
            ];
        
            if (isset($receiptAmount['id'])) {
                ReceiptAmount::updateOrCreate(['id' => $receiptAmount['id']], $data);
            } else {
                ReceiptAmount::create($data);
            }
        }

        ReceiptAmount::whereIn('id',$this->deletedReceiptAmount)->delete();


        session()->flash('success', 'receipt has been updated successfully!');

        return redirect()->route('receipt');
    }
    
    public function render()
    {

        $users = User::all();
        $currencies = Currency::all();

        return view('livewire.pcash.receipt-form',compact('users','currencies'));
    }
}
