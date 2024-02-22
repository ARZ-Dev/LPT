<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\PaymentAmount;
use App\Models\SubCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class PaymentForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $payment;

    public $category_id;
    public $sub_category_id;
    public $description;

    public  $paymentAmount=[];
    public $payment_id;
    public $currency_id;
    public $amount;


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('payment-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();
        

        if ($id) {
            $this->editing = true;
            $this->payment = Payment::findOrFail($id);

            $this->category_id = $this->payment->category_id;
            $this->sub_category_id = $this->payment->sub_category_id;
            $this->description = $this->payment->description;

            $this->paymentAmount = $this->payment->paymentAmount->toArray();
        }

    }

    protected function rules()
    {
        $rules = [
            'category_id' => ['required', 'integer'],
            'sub_category_id' => ['required', 'integer'],
            'description' => ['nullable', 'string'],

            'paymentAmount' => ['array'],
            'paymentAmount.*.payment_id' => ['nullable'],
            'paymentAmount.*.currency_id' => ['required'],
            'paymentAmount.*.amount' => ['required'],  
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->paymentAmount[] = ['currency_id' => '','amount' => ''];  
        
        
    }

    public function removePaymentAmount($key)
    {
        if (isset($this->paymentAmount[$key])) {
        $paymentIndex = $this->paymentAmount[$key];
        if (isset($paymentIndex['id'])) {
            PaymentAmount::find($paymentIndex['id'])->delete();
        }
        unset($this->paymentAmount[$key]);
        $this->paymentAmount = array_values($this->paymentAmount);
    }}



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
    $this->authorize('payment-edit');

    $this->validate();

    $payment=Payment::create([
        'category_id' => $this->category_id ,
        'sub_category_id' => $this->sub_category_id ,
        'description' => $this->description ,
    ]);

    $paymentId = $payment->id;
    foreach ($this->paymentAmount as $paymentAmount) {
        PaymentAmount::create([
            'payment_id' => $paymentId,
            'currency_id' => $paymentAmount['currency_id'],
            'amount' => $this->sanitizeNumber($paymentAmount['amount']),
        ]);
    }


    session()->flash('success', 'payment has been created successfully!');

    return redirect()->route('payment');
}


    public function update()
    {
        $this->authorize('payment-edit');

        $this->validate();

        $this->payment->update([
            'category_id' => $this->category_id ,
            'sub_category_id' => $this->sub_category_id ,
            'description' => $this->description ,
        ]);

        foreach ($this->paymentAmount as $paymentAmount) {
            $data = [
                'payment_id' => $this->payment->id,
                'currency_id' => $paymentAmount['currency_id'],
                'amount' => $this->sanitizeNumber($paymentAmount['amount']),
            ];
        
            if (isset($paymentAmount['id'])) {
                PaymentAmount::updateOrCreate(['id' => $paymentAmount['id']], $data);
            } else {
                PaymentAmount::create($data);
            }
        }

        session()->flash('success', 'payment has been updated successfully!');

        return redirect()->route('payment');
    }
    
    public function render()
    {
        $categories = Category::all();
        $subCategories = SubCategory::where('category_id', $this->category_id)->get();
        $currencies = Currency::all();



        return view('livewire.pcash.payment-form',compact('categories','subCategories','currencies'));
    }
}
