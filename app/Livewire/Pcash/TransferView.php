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
    public array $tillsIds = [];
    public bool $isSuperAdmin = false;

    public function mount()
    {
        $this->authorize('transfer-list');

        $this->tillsIds = auth()->user()->tills()->pluck('id')->toArray();
        $this->isSuperAdmin = auth()->user()->hasRole('Super Admin');

        $this->transfers = Transfer::with(['fromTill.user','toTill'])
            ->when(!auth()->user()->hasPermissionTo('transfer-viewAll'), function ($query) {
                $query->where('user_id', auth()->id())
                    ->orWhereIn('from_till_id', $this->tillsIds)
                    ->orWhereIn('to_till_id', $this->tillsIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();

    }

    public function delete($id)
    {
        $this->authorize('transfer-delete');

        $transfer = Transfer::with(['transferAmounts'])->findOrFail($id);

        $transfer->delete();

        return to_route('transfer')->with('success', 'transfer has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.transfer.transfer-index');
    }
}
