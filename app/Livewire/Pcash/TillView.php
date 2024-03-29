<?php

namespace App\Livewire\Pcash;

use App\Models\Till;
use App\Models\Transfer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class TillView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $tills;

    public function mount()
    {
        $this->authorize('till-list');

        $this->tills = Till::with(['user'])
            ->when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')->get();
    }

    public function delete($id)
    {
        $this->authorize('till-delete');

        $till = Till::withCount(['fromTransfer', 'toTransfer', 'tillAmounts', 'payments', 'receipts', 'monthlyEntries'])->findOrFail($id);

        $cannotDelete = $till->from_transfers_count || $till->to_transfers_count || $till->payments_count || $till->receipts_count || $till->monthly_entries_count;
        if ($cannotDelete) {
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => "Cannot delete a till that has transfers, payments, receipts, or monthly opening/closing!",
            ]);
        }

        $till->tillAmounts()->delete();
        $till->delete();

        return to_route('till')->with('success', 'till has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.tills.till-index');
    }
}
