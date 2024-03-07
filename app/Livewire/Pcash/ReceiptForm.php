<?php

namespace App\Livewire\Pcash;


use App\Models\Currency;
use App\Models\Receipt;
use App\Models\ReceiptAmount;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Exception;
class ReceiptForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $receipt;

    public $tills;

    public $till_id;
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
        $this->tills = Till::all();


        if ($id) {
            $this->editing = true;
            $this->receipt = Receipt::with('receiptAmount')->findOrFail($id);

            $this->till_id = $this->receipt->till_id;

            $this->paid_by = $this->receipt->paid_by;
            $this->description = $this->receipt->description;
            $this->receiptAmount = [];
            foreach($this->receipt->receiptAmount as $receiptAmount) {
                $this->receiptAmount[] = [
                    'id' => $receiptAmount->id,
                    'receipt_id' => $receiptAmount->receipt_id,
                    'currency_id' => $receiptAmount->currency_id,
                    'amount' => number_format($receiptAmount->amount),
                ];
            }

        }

    }

    protected function rules()
    {
        $rules = [
            'till_id' => ['required'],
            'paid_by' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'receiptAmount' => ['array'],
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
        if($this->editing == true){
            $removedItemId = $this->receiptAmount[$key]['id'] ?? null;
            $this->deletedReceiptAmount[] = $removedItemId;
            sanitizeNumber($this->receiptAmount[$key]['amount']);
        }

        unset($this->receiptAmount[$key ]);


    }

    public function store()
    {
        $this->authorize('receipt-create');
        $this->validate();

        DB::beginTransaction();
        try {

            $receipt=Receipt::create([
                'till_id' => $this->till_id,
                'user_id' => auth()->id(),
                'paid_by' => $this->paid_by ,
                'description' => $this->description ,
            ]);

            $receiptId = $receipt->id;
            foreach ($this->receiptAmount as $receiptAmount) {
                ReceiptAmount::create([
                    'receipt_id' => $receiptId,
                    'currency_id' => $receiptAmount['currency_id'],
                    'amount' => sanitizeNumber($receiptAmount['amount']),
                ]);

                $tillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id',$receiptAmount['currency_id'])->first();

                if ($tillAmount) {
                    $tillAmount->update([
                        'amount' => $tillAmount->amount + sanitizeNumber($receiptAmount['amount']),
                    ]);
                } else {
                    TillAmount::create([
                        'till_id' => $this->till_id,
                        'currency_id' => $receiptAmount['currency_id'],
                        'amount' => sanitizeNumber($receiptAmount['amount'])
                    ]);
                }
            }


            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('receipt')->with('success', 'receipt has been created successfully!');
    }


    public function update()
    {
        $this->authorize('receipt-edit');
        $this->validate();

        DB::beginTransaction();
        try {

            $existingReceiptAmounts = ReceiptAmount::where('receipt_id', $this->receipt->id)->get();
            foreach ($existingReceiptAmounts as $existingReceiptAmount) {
                $tillAmount = TillAmount::where('till_id', $this->receipt->till_id)
                    ->where('currency_id', $existingReceiptAmount->currency_id)
                    ->first();

                if ($tillAmount) {
                    $updatedAmount = $tillAmount->amount - $existingReceiptAmount->amount;

                    $tillAmount->update([
                        'amount' => $updatedAmount,
                    ]);
                }
            }

            $this->receipt->update([
                'till_id' => $this->till_id,
                'paid_by' => $this->paid_by ,
                'description' => $this->description,
            ]);

            $receiptAmountsIds = [];
            foreach ($this->receiptAmount as $receiptAmount) {

                $receipt = ReceiptAmount::updateOrCreate([
                    'id' => $receiptAmount['id'] ?? 0,
                ],[
                    'receipt_id' => $this->receipt->id,
                    'currency_id' => $receiptAmount['currency_id'],
                    'amount' => sanitizeNumber($receiptAmount['amount']),
                ]);
                $receiptAmountsIds[] = $receipt->id;

                $tillAmount = TillAmount::where('till_id', $this->till_id)
                    ->where('currency_id', $receiptAmount['currency_id'])
                    ->first();

                if ($tillAmount) {
                    $tillAmount->update([
                        'amount' => $tillAmount->amount + sanitizeNumber($receiptAmount['amount']),
                    ]);
                } else {
                    TillAmount::create([
                        'till_id' => $this->till_id,
                        'currency_id' => $receiptAmount['currency_id'],
                        'amount' => sanitizeNumber($receiptAmount['amount'])
                    ]);
                }
            }
            ReceiptAmount::where('receipt_id', $this->receipt->id)->whereNotIn('id', $receiptAmountsIds)->delete();

            DB::commit();

            return redirect()->route('receipt')->with('success', 'receipt has been updated successfully!');

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $exception->getMessage(),
            ]);
        }
    }

    public function render()
    {

        $users = User::all();
        $currencies = Currency::all();

        return view('livewire.pcash.receipt-form',compact('users','currencies'));
    }
}
