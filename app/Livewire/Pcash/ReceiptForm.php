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
            $this->receiptAmount = [];
            foreach($this->receipt->receiptAmount as $receiptAmount) {
                $this->receiptAmount[] = [
                    'id' => $receiptAmount->id,
                    'receipt_id' => $receiptAmount->receipt_id,
                    'currency_id' => $receiptAmount->currency_id,
                    'amount' => $this->sanitizeNumber($receiptAmount->amount),
                ];
            }
            
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

    public function removeRow($key)
    {
        unset($this->receiptAmount[$key]);

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

        $receiptAmountsIds = [];
        foreach ($this->receiptAmount as $receiptAmount) {

            $receipt = ReceiptAmount::updateOrCreate([
                'id' => $receiptAmount['id'] ?? 0,
            ],[
                'receipt_id' => $this->receipt->id,
                'currency_id' => $receiptAmount['currency_id'],
                'amount' => $this->sanitizeNumber($receiptAmount['amount']),
            ]);

            $receiptAmountsIds[] = $receipt->id;
        }

        ReceiptAmount::whereNotIn('id', $receiptAmountsIds)->delete();


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
