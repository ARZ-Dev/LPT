<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\MonthlyEntry;
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
use App\Utils\Constants;



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
    public $paid_to;
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
    public bool $submitting = false;


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {

        $this->status=$status;
        $this->addRow();

        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        $this->categories = Category::when(!auth()->user()->hasPermissionTo('category-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->where('type', 'payment')
            ->get();

        $this->currencies = Currency::all();

        if ($id) {
            if ($status && $status == Constants::VIEW_STATUS) {
                $this->authorize('payment-view');
            } else {
                $this->authorize('payment-edit');
            }


            $this->payment_id=$id;
            $this->editing = true;
            $this->payment = Payment::findOrFail($id);

            $this->authorize('view',$this->payment);

            $this->user_id = $this->payment->user_id;
            $this->till_id = $this->payment->till_id;

            $this->category_id = $this->payment->category_id;
            $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
            $this->sub_category_id = $this->payment->sub_category_id;
            $this->paid_to = $this->payment->paid_to;
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
        } else {
            $this->authorize('payment-create');

            if (count($this->tills) == 1) {
                $this->till_id = $this->tills[0]->id;
            }

            if (count($this->categories) == 1) {
                $this->category_id = $this->categories[0]->id;
                $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();

                if (count($this->subCategories) == 1) {
                    $this->sub_category_id = $this->subCategories[0]->id;
                }
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
            'paid_to' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'invoice' => ['nullable', 'file', 'max:2048'],

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

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            checkMonthlyOpening($this->till_id);

            $path = null;
            if ($this->invoice && !is_string($this->invoice)) {
                $path = $this->invoice->storePublicly(path: 'public/invoices');
            }

            $payment = Payment::create([
                'user_id' => auth()->id(),
                'till_id' => $this->till_id,
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'paid_to' => $this->paid_to,
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
            $this->submitting = false;

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

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

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
                'paid_to' => $this->paid_to,
                'paid_to' => $this->paid_to,
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
            $this->submitting = false;

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
        $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
        $selectedSubCategoryId = null;
        if ($this->payment) {
            $selectedSubCategoryId = $this->payment?->sub_category_id;
        } else {
            if (count($this->subCategories) == 1) {
                $selectedSubCategoryId = $this->subCategories[0]->id;
                $this->sub_category_id = $selectedSubCategoryId;
            }
        }
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



        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.payment.payment-view');
        }
            return view('livewire.pcash.payment.payment-form');
        }
    }

