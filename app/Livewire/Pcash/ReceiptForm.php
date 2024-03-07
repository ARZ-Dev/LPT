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
    public $users;
    public $currencies;
    public $receipt;
    public $tills;
    public $till_id;
    public $user_id;
    public $paid_by;
    public $description;
    public  $receiptAmounts = [];

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('receipt-list');

        $this->status = $status;

        $this->users = User::all();
        $this->currencies = Currency::all();
        $this->tills = Till::all();

        $this->addRow();

        if ($id) {
            $this->editing = true;
            $this->receipt = Receipt::with('receiptAmounts')->findOrFail($id);

            $this->till_id = $this->receipt->till_id;

            $this->paid_by = $this->receipt->paid_by;
            $this->description = $this->receipt->description;
            $this->receiptAmounts = [];
            foreach($this->receipt->receiptAmounts as $receiptAmount) {
                $this->receiptAmounts[] = [
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
        return [
            'till_id' => ['required'],
            'paid_by' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'receiptAmounts' => ['array', 'min:1'],
            'receiptAmounts.*.currency_id' => ['required'],
            'receiptAmounts.*.amount' => ['required'],
        ];
    }

    public function addRow()
    {
        $this->receiptAmounts[] = [
            'currency_id' => '',
            'amount' => ''
        ];
    }

    public function removeRow($key)
    {
        unset($this->receiptAmounts[$key]);
    }

    public function store()
    {
        $this->authorize('receipt-create');
        $this->validate();

        DB::beginTransaction();
        try {

            $receipt = Receipt::create([
                'till_id' => $this->till_id,
                'user_id' => auth()->id(),
                'paid_by' => $this->paid_by ,
                'description' => $this->description ,
            ]);

            $receiptId = $receipt->id;
            foreach ($this->receiptAmounts as $receiptAmount) {
                ReceiptAmount::create([
                    'receipt_id' => $receiptId,
                    'currency_id' => $receiptAmount['currency_id'],
                    'amount' => sanitizeNumber($receiptAmount['amount']),
                ]);

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
            foreach ($this->receiptAmounts as $receiptAmount) {

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

            return redirect()->route('receipt')->with('success', 'Receipt has been updated successfully!');

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
        return view('livewire.pcash.receipt-form');
    }
}
