<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\Transfer;
use App\Models\TransferAmount;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Utils\Constants;


class TransferForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;
    public $transfer;
    public $to_tills;
    public $user_id;
    public int $from_till_id;
    public int $to_till_id;
    public  $description;
    public $transferAmounts = [];
    public $currency_id;
    public $amount;
    public $tills = [];
    public $currencies = [];
    public bool $submitting = false;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        $this->to_tills = Till::all();

        $this->currencies = Currency::all();

        $this->status = $status;
        $this->addRow();

        if ($id) {

            if ($status && $status == Constants::VIEW_STATUS) {
                $this->authorize('transfer-view');
            } else {
                $this->authorize('transfer-edit');
            }

            $this->editing = true;
            $this->transfer = Transfer::with('transferAmounts')->findOrFail($id);
            $this->authorize('view',$this->transfer);
            $this->user_id = $this->transfer->user_id;
            $this->from_till_id = $this->transfer->from_till_id;
            $this->to_till_id = $this->transfer->to_till_id;
            $this->description = $this->transfer->description;

            $this->transferAmounts = [];
            foreach ($this->transfer->transferAmounts as $transferAmount) {
                $this->transferAmounts[] = [
                    'id' => $transferAmount->id,
                    'amount' => number_format($transferAmount->amount),
                    'currency_id' => $transferAmount->currency_id,
                ];
            }
        } else {
            $this->authorize('transfer-create');
            if (count($this->tills) == 1) {
                $this->from_till_id = $this->tills[0]->id;
            }
        }

    }

    protected function rules()
    {
        return [
            'from_till_id' => ['required', 'different:to_till_id'],
            'to_till_id' => ['required', 'different:from_till_id'],
            'description' => ['nullable'],
            'transferAmounts' => ['array'],
            'transferAmounts.*.transfer_id' => ['nullable'],
            'transferAmounts.*.currency_id' => ['required', 'distinct'],
            'transferAmounts.*.amount' => ['required'],
        ];
    }

    public function addRow()
    {
        $this->transferAmounts[] = ['currency_id' => '','amount' => ''];
    }

    public function removeRow($key)
    {
        unset($this->transferAmounts[$key]);
    }

    public function store()
    {
        $this->authorize('transfer-create');
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {

            checkMonthlyOpening($this->from_till_id);
            checkMonthlyOpening($this->to_till_id);

            $transfer=Transfer::create([
                'user_id' => auth()->id() ,
                'from_till_id' => $this->from_till_id ,
                'to_till_id' => $this->to_till_id ,
                'description' => $this->description ,
            ]);

            $transferId = $transfer->id;
            foreach ($this->transferAmounts as $transferAmount) {
                TransferAmount::create([
                    'transfer_id' => $transferId,
                    'currency_id' => $transferAmount['currency_id'],
                    'amount' => sanitizeNumber($transferAmount['amount']),
                ]);

                $this->updateTillsAmounts($transferAmount);
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

        return to_route('transfer')->with('success', 'transfer has been created successfully!');
    }

    public function update()
    {
        $this->authorize('transfer-edit');
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        DB::beginTransaction();
        try {
            $transferAmounts = TransferAmount::with('transfer.fromTill', 'transfer.toTill')
                ->whereHas('transfer.fromTill', function ($query) {
                    $query->where('id', $this->transfer->from_till_id);
                })
                ->whereHas('transfer.toTill', function ($query) {
                    $query->where('id', $this->transfer->to_till_id);
                })
                ->where('transfer_id', $this->transfer->id)
                ->get();

            foreach ($transferAmounts as $transferAmount) {
                $amount = $transferAmount->amount;

                $fromTill = TillAmount::where('till_id', $this->transfer->from_till_id)->where('currency_id',$transferAmount['currency_id'])->first();
                if (!$fromTill) {
                    throw new Exception("From till amount does not exists!");
                }

                $toTill = TillAmount::where('till_id', $this->transfer->to_till_id)->where('currency_id',$transferAmount['currency_id'])->first();

                $fromTill->update([
                    'amount' => $fromTill->amount + $amount,
                ]);

                if ($toTill) {
                    $toTill->update([
                        'amount' => $toTill->amount - $amount,
                    ]);
                }
            }

            $this->transfer->update([
                'from_till_id' => $this->from_till_id,
                'to_till_id' => $this->to_till_id,
                'description' => $this->description,
            ]);

            $transfersAmountIds = [];
            foreach ($this->transferAmounts as $transferAmount) {

                $amount = TransferAmount::updateOrCreate([
                    'id' => $transferAmount['id'] ?? 0,
                ],[
                    'transfer_id' => $this->transfer->id,
                    'currency_id' => $transferAmount['currency_id'],
                    'amount' => sanitizeNumber($transferAmount['amount']),
                ]);
                $transfersAmountIds[] = $amount->id;

                $this->updateTillsAmounts($transferAmount);
            }
            TransferAmount::where('transfer_id', $this->transfer->id)->whereNotIn('id', $transfersAmountIds)->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->submitting = false;

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('transfer')->with('success', 'transfer has been updated successfully!');
    }


    public function updateTillsAmounts(mixed $transferAmount): void
    {
        $fromTill = TillAmount::where('till_id', $this->from_till_id)->where('currency_id', $transferAmount['currency_id'])->first();
        if (!$fromTill || ($fromTill->amount < sanitizeNumber($transferAmount['amount']))) {
            throw new Exception("Cannot transfer, transferred amount does not exists!");
        }

        $toTill = TillAmount::where('till_id', $this->to_till_id)->where('currency_id', $transferAmount['currency_id'])->first();

        $fromTill->update([
            'amount' => $fromTill->amount - sanitizeNumber($transferAmount['amount']),
        ]);

        if ($toTill) {
            $toTill->update([
                'amount' => $toTill->amount + sanitizeNumber($transferAmount['amount']),
            ]);
        } else {
            TillAmount::create([
                'till_id' => $this->to_till_id,
                'currency_id' => $fromTill->currency_id,
                'amount' => sanitizeNumber($transferAmount['amount']),
            ]);
        }
    }

    #[On('getAvailableAmounts')]
    public function getAvailableAmounts()
    {
        if (isset($this->from_till_id)) {
            $till = Till::with('tillAmounts')->find($this->from_till_id);
            $availableAmounts = [];
            foreach ($till?->tillAmounts ?? [] as $tillAmount) {
                if ($this->transfer && $this->transfer->from_till_id == $till?->id) {
                    $transferAmount = $this->transfer->transferAmounts->where('currency_id', $tillAmount->currency_id)->first()?->amount ?? 0;
                    $amount = $tillAmount->amount + $transferAmount;
                } else {
                    $amount = $tillAmount->amount;
                }
                $availableAmounts[$tillAmount->currency_id] = number_format($amount, 2);
            }

            $this->dispatch('setAvailableAmounts', $availableAmounts);
        }
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.transfer.transfer-view');
        }
        return view('livewire.pcash.transfer.transfer-form');
    }
}

