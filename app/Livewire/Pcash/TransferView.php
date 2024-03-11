<?php

namespace App\Livewire\Pcash;

use App\Models\TillAmount;
use App\Models\Transfer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TransferView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $transfers;

    public function mount(){
        $this->authorize('transfer-list');
        $this->transfers = Transfer::with(['fromTill.user','toTill'])->get();
    }

    public function delete($id)
    {
        $this->authorize('transfer-delete');

        $transfer = Transfer::with(['transferAmounts'])->findOrFail($id);

        foreach ($transfer->transferAmounts as $transferAmount) {
            $fromTill = TillAmount::where('till_id', $transfer->from_till_id)->where('currency_id', $transferAmount->currency_id)->first();
            $toTill = TillAmount::where('till_id', $transfer->to_till_id)->where('currency_id', $transferAmount->currency_id)->first();

            if ($fromTill) {
                $fromTill->update([
                    'amount' => $fromTill->amount + $transferAmount->amount,
                ]);
            }

            if ($toTill) {
                $toTill->update([
                    'amount' => $toTill->amount - $transferAmount->amount,
                ]);
            }
        }

        $transfer->delete();

        return to_route('transfer')->with('success', 'transfer has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.transfer-view');
    }
}
