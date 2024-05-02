<?php

namespace App\Livewire\Pcash;

use App\Models\MonthlyEntry;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class MonthlyEntryView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $monthlyEntries;

    public function mount()
    {
        $this->authorize('monthlyEntry-list');
        $this->monthlyEntries = MonthlyEntry::with(['monthlyEntryAmounts'])
            ->when(!auth()->user()->hasPermissionTo('monthlyEntry-viewAll'), function ($query) {
                $query->whereHas('till', function ($query) {
                    $query->where('user_id', auth()->id());
                });
            })
            ->orderBy('created_at', 'desc')->get();

    }

    public function delete($id)
    {
        $this->authorize('monthlyEntry-delete');

        $monthlyEntry = MonthlyEntry::with('monthlyEntryAmounts')->findOrFail($id);

        $monthlyEntry->monthlyEntryAmounts()->delete();
        $monthlyEntry->delete();

        return to_route('monthly-openings-closings')->with('success', 'Month has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.monthlyEntry.monthlyEntry-index');
    }
}



