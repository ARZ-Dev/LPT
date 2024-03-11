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
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
use Livewire\WithFileUploads;


class PaymentForm extends Component
{
    use AuthorizesRequests ,  WithFileUploads;

    public $editing = false;
    public int $status;

    public $payment;

    public $user_id;
    public $till_id;

    public $category_id;
    public $sub_category_id;
    public $description;
    public $invoice;


    public  $paymentAmounts = [];
    public $payment_id;
    public $currency_id;
    public $amount;

    public $tills;

    public $categories;
    public $subCategories = [];
    public $currencies;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('payment-list');

        $this->status=$status;
        $this->addRow();

        $this->tills = Till::all();

        $this->categories = Category::all();
        $this->currencies = Currency::all();

        if ($id) {
            $this->payment_id=$id;
            $this->editing = true;
            $this->payment = Payment::findOrFail($id);

            $this->user_id = $this->payment->user_id;
            $this->till_id = $this->payment->till_id;

            $this->category_id = $this->payment->category_id;
            $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
            $this->sub_category_id = $this->payment->sub_category_id;
            $this->description = $this->payment->description;
            $this->invoice = $this->payment->invoice;


            $this->paymentAmounts = [];
            foreach ($this->payment->paymentAmounts as $paymentAmount) {
                $this->paymentAmounts[] = [
                    'id' => $paymentAmount->id,
                    'amount' => number_format($paymentAmount->amount),
                    'currency_id' => $paymentAmount->currency_id,
                ];
            }
        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['nullable'],
            'till_id' => ['required', 'integer'],

            'category_id' => ['required', 'integer'],
            'sub_category_id' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'invoice' => ['nullable'],

            'paymentAmounts' => ['array'],
            'paymentAmounts.*.payment_id' => ['nullable'],
            'paymentAmounts.*.currency_id' => ['required'],
            'paymentAmounts.*.amount' => ['required'],
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->paymentAmounts[] = ['currency_id' => '','amount' => ''];
    }


    public function removeRow($key)
    {
        unset($this->paymentAmounts[$key]);
    }

    public function store()
    {
        $this->authorize('payment-create');

        $this->validate();

        DB::beginTransaction();
        try {

            $path = null;
            if ($this->invoice && !is_string($this->invoice)) {
                $path = $this->invoice->storePublicly(path: 'public/invoices');
            }

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'till_id' => $this->till_id,
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'description' => $this->description,
                'invoice' => $path,
            ]);

            $paymentId = $payment->id;
            foreach ($this->paymentAmounts as $paymentAmount) {
                PaymentAmount::create([
                    'payment_id' => $paymentId,
                    'currency_id' => $paymentAmount['currency_id'],
                    'amount' => sanitizeNumber($paymentAmount['amount']),
                ]);

                $this->updateTillsAmounts($paymentAmount);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('payment')->with('success', 'Payment has been created successfully!');
    }

    public function update()
    {
        $this->authorize('payment-edit');
        $this->validate();

        DB::beginTransaction();
        try {
            $existingPaymentAmounts = PaymentAmount::where('payment_id', $this->payment->id)->get();
            foreach ($existingPaymentAmounts as $existingPaymentAmount) {
                $tillAmount = TillAmount::where('till_id', $this->payment->till_id)
                    ->where('currency_id', $existingPaymentAmount->currency_id)
                    ->first();

                if ($tillAmount) {
                    $updatedAmount = $tillAmount->amount + $existingPaymentAmount->amount;

                    $tillAmount->update([
                        'amount' => $updatedAmount,
                    ]);
                }
            }

            $data = [
                'till_id' => $this->till_id,
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'description' => $this->description,
            ];

            if ($this->invoice && !is_string($this->invoice)) {
                $data['invoice'] = $this->invoice->storePublicly(path: 'public/invoices');
            }

            $this->payment->update($data);

            $paymentAmountsIds = [];
            foreach ($this->paymentAmounts as $paymentAmount) {

                $amount = PaymentAmount::updateOrCreate([
                    'id' => $paymentAmount['id'] ?? 0,
                ],[
                    'payment_id' => $this->payment_id,
                    'amount' => sanitizeNumber($paymentAmount['amount']),
                    'currency_id' => $paymentAmount['currency_id'],
                ]);
                $paymentAmountsIds[] = $amount->id;

                $this->updateTillsAmounts($paymentAmount);

            }
            PaymentAmount::where('payment_id', $this->payment_id)->whereNotIn('id', $paymentAmountsIds)->delete();

            DB::commit();

            return to_route('payment')->with('success', 'Payment has been updated successfully!');
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * @param mixed $paymentAmount
     * @return void
     */
    public function updateTillsAmounts(mixed $paymentAmount): void
    {
        $tillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id', $paymentAmount['currency_id'])->first();

        if ($tillAmount) {
            $tillAmount->update([
                'amount' => $tillAmount->amount - sanitizeNumber($paymentAmount['amount']),
            ]);
        } else {
            $newTillAmount = new TillAmount();
            $newTillAmount->till_id = $this->till_id;
            $newTillAmount->amount = -sanitizeNumber($paymentAmount['amount']);
            $newTillAmount->currency_id = $paymentAmount['currency_id'];
            $newTillAmount->save();
        }
    }

    #[On('getSubCategories')]
    public function getSubCategories()
    {
        $this->sub_category_id = null;
        $selectedSubCategoryId = $this->payment?->sub_category_id;
        $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
        $this->dispatch('refreshSubCategories', $this->subCategories, $selectedSubCategoryId);
    }

    #[On('deleteInvoice')]
    public function deleteInvoice()
    {
        if ($this->payment) {
            $this->payment->invoice = NULL;
            $this->payment->save();
        }
    }

    public function render()
    {

        return view('livewire.pcash.payment-form');
    }
}
