<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\SubCategory;
use App\Models\Till;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class ReportView extends Component
{
    use AuthorizesRequests;

    public $reportData;

    public function mount(){
        $tables = [
            'currencies' => Currency::class,
            'tills' => Till::class,
            'payments' => Payment::class,
            'receipts' => Receipt::class,
            'transfers' => Transfer::class,
            'exchanges' => Exchange::class,
        ];

        $this->reportData = collect();

        foreach ($tables as $section => $model) {

            $entries = $model::all();
            
            foreach ($entries as $entry) {
                $this->reportData->push([
                    'model' => $model,
                    'section' => $section,
                    'id' => $entry->id,
                    'user'=> User::find($entry->user_id),
                    'name' => $entry->name,
                    'amount'=>$entry->amount,
                    'paid_by'=>$entry->paid_by,
                    
                    'from_till_id'=>Till::find($entry->from_till_id),
                    'to_till_id'=>Till::find($entry->to_till_id),

                    'date' => $entry->created_at,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.pcash.report-view');
    }
}
