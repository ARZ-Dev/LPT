<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\PaymentAmount;
use App\Models\SubCategory;
use App\Models\Till;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;


class PaymentForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $payment;

    public $till_id;
    public $category_id;
    public $sub_category_id;
    public $description;

    public  $paymentAmount=[];
    public $payment_id;
    public $currency_id;
    public $amount;


    public $tills;


    public $categories;
    public $subCategories;
    public $currencies;
    
    public $deletedPaymentAmount=[];


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('payment-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();

        $this->tills = Till::Where('user_id',auth()->id())->get();

        
        $this->categories = Category::all();
        $this->currencies = Currency::all();
        $this->updateSubCategories();
        
        if ($id) {
            $this->payment_id=$id;
            $this->editing = true;
            $this->payment = Payment::findOrFail($id);

            $this->till_id = $this->payment->till_id;
            $this->category_id = $this->payment->category_id;
            $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
            $this->sub_category_id = $this->payment->sub_category_id;
            $this->description = $this->payment->description;

            $this->paymentAmount = $this->payment->paymentAmount->toArray();

        }



       
        
    }
    

    protected function rules()
    {
        $rules = [
            'till_id' => ['required', 'integer'],
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

    

    public function removeRow($key)
    {
        if($this->editing == true){
            $removedItemId = $this->paymentAmount[$key]['id'] ?? null;
            $this->deletedPaymentAmount[] = $removedItemId;
            $this->sanitizeNumber($this->paymentAmount[$key]['amount']);
        }

        unset($this->paymentAmount[$key ]);
   
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
        $this->authorize('payment-edit');

        $this->validate();

        DB::beginTransaction();
        try {

        $payment = Payment::create([
            'till_id' => $this->till_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'description' => $this->description,
        ]);

        $paymentId = $payment->id;
        foreach ($this->paymentAmount as $paymentAmount) {
            PaymentAmount::create([
                'payment_id' => $paymentId,
                'currency_id' => $paymentAmount['currency_id'],
                'amount' => $this->sanitizeNumber($paymentAmount['amount']),
            ]);
            
            $tillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id',$paymentAmount['currency_id'])->first();

            if ($tillAmount->amount < $this->sanitizeNumber($paymentAmount['amount'])) {
                throw new Exception("Cannot pay, payment amount does not exists");
            }

            if ($tillAmount->amount > $this->sanitizeNumber( $paymentAmount['amount'])) {

                $tillAmount->update([
                    'amount' => $tillAmount->amount - $this->sanitizeNumber($paymentAmount['amount']),
                ]);
            }
        }
        
        session()->flash('success', 'Payment has been created successfully!');
        
        DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return redirect()->route('payment');
    }



    public function update()
    {
        $this->authorize('payment-edit');
    
        $this->validate();
    
        DB::beginTransaction();
    
        try {
            $this->payment->update([
                'till_id' => $this->till_id,
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'description' => $this->description,
            ]);
    
            foreach ($this->paymentAmount as $paymentAmount) {
                $data = [
                    'payment_id' => $this->payment->id,
                    'amount' => $this->sanitizeNumber($paymentAmount['amount']),
                    'currency_id' => $paymentAmount['currency_id'],
                ];
    
                $oldpaymentAmount = Payment::where('id', $this->payment_id)
                    ->with(['paymentamount' => function ($query) use ($paymentAmount) {
                        $query->where('currency_id', $paymentAmount['currency_id']);
                    }])
                    ->first();
    
                $tillAmount = TillAmount::where('till_id', $this->till_id)
                    ->where('currency_id', $paymentAmount['currency_id'])
                    ->first();
    
                if ($tillAmount->amount < $this->sanitizeNumber($paymentAmount['amount'])) {
                    throw new Exception("Cannot pay, payment amount does not exist");
                }
    
                if ($tillAmount->amount > $this->sanitizeNumber($paymentAmount['amount'])) {
                    if (isset($paymentAmount['id'])) {
                        PaymentAmount::updateOrCreate(['id' => $paymentAmount['id']], $data);
                    } else {
                        PaymentAmount::create($data);
                    }
    
                    $updatedAmount = $oldpaymentAmount->paymentamount->pluck('amount')->first() + $tillAmount->amount - $this->sanitizeNumber($paymentAmount['amount']);
                    $tillAmount->update([
                        'amount' => $updatedAmount,
                    ]);
                }
            }
    
            // Handle deleted payment amounts
            $deletedPaymentAmounts = PaymentAmount::whereIn('id', $this->deletedPaymentAmount)->get();
    
            foreach ($deletedPaymentAmounts as $deletedPaymentAmount) {
                $deletedTillAmount = TillAmount::where('till_id', $this->till_id)
                    ->where('currency_id', $deletedPaymentAmount->currency_id)
                    ->first();
    
                // Assuming $deletedTillAmount is found, update its amount
                if ($deletedTillAmount) {
                    $deletedTillAmount->update([
                        'amount' => $deletedTillAmount->amount + $deletedPaymentAmount->amount,
                    ]);
                }
            }
    
            PaymentAmount::whereIn('id', $this->deletedPaymentAmount)->delete();
    
            session()->flash('success', 'Payment has been updated successfully!');
    
            DB::commit();
            return redirect()->route('payment');
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $exception->getMessage(),
            ]);
        }
    }
    
    

    public function updateSubCategories()
    {
        $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
        $this->sub_category_id = null;
    }
    public function updatedCategory_id()
    {
        $this->updateSubCategories();
    }
    
    public function render()
    {

        return view('livewire.pcash.payment-form');
    }
}
