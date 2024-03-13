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
        // $this->monthlyEntries = MonthlyEntry::all();
        $this->monthlyEntries = MonthlyEntry::with(['monthlyEntryAmounts'])
        ->when(!auth()->user()->hasPermissionTo('monthlyEntry-viewAll'), function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->get();
    
    }

    public function delete($id)
    {
        $this->authorize('monthlyEntry-delete');

        $monthlyEntry = MonthlyEntry::with('monthlyEntryAmounts')->findOrFail($id);



        foreach ($monthlyEntry->monthlyEntryAmounts as $monthlyEntryAmount) {

            $tillAmount = TillAmount::where('till_id', $monthlyEntry->till_id)->where('currency_id', $monthlyEntryAmount->currency_id)->first();

            if ($tillAmount) {
                $tillAmount->update([
                    'amount' => $tillAmount->amount + $monthlyEntryAmount->amount,
                ]);
            }

            $monthlyEntryAmount->delete();
        }

        $monthlyEntry->delete();

        return to_route('monthlyEntry')->with('success', 'MonthlyEntry has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.monthlyEntry.monthlyEntry-index');
    }
}
