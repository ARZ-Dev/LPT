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

    public function render()
    {
        $data = [];

        $tables = [
            'categories' => Category::class,
            'currencies' => Currency::class,
            'tills' => Till::class,
            'payments' => Payment::class,
            'receipts' => Receipt::class,
            'transfers' => Transfer::class,
            'exchanges' => Exchange::class,
        ];

        $reportData = collect();

        foreach ($tables as $section => $model) {

            $entries = $model::all();
            foreach ($entries as $entry) {
                $reportData->push([
                    'section' => $section,
                    'model' => $model,
                    'date' => $entry->created_at,
                    'id' => $entry->id,
                    'category_name' => $entry->category_name,
                    'name' => $entry->name,
                    'amount'=>$entry->amount,
                    'paid_by'=>$entry->paid_by,
                    'category_id'=> Category::find($entry->category_id),
                    'subcategories'=>SubCategory::where('category_id',$entry->id)->get(),
                    'user_id'=> User::find($entry->user_id),
                ]);
            }
        }
        $data['reportData'] = $reportData;

        return view('livewire.pcash.report-view', $data);
    }
}
