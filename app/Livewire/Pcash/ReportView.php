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
    public $currencies = [];

    public function mount()
    {
        $this->currencies = Currency::all();
        $tables = [
            'payment' => Payment::class,
            'receipt' => Receipt::class,
            'transfer' => Transfer::class,
            'exchange' => Exchange::class,
        ];

        $this->reportData = collect();

        foreach ($tables as $section => $model) {

            $entries = $model::all();

            $amounts = [];
            foreach ($entries as $entry) {

                if ($section == "payment") {
                    foreach ($entry->paymentAmounts as $paymentAmount) {
                        $amounts[$paymentAmount->currency_id] = [
                            'debit' => 0,
                            'credit' => $paymentAmount->amount,
                            'balance' => 0,
                        ];
                    }
                } else if ($section == "transfer") {

                } else if ($section == "receipt") {
                    foreach ($entry->receiptAmounts as $receiptAmount) {
                        $amounts[$receiptAmount->currency_id] = [
                            'debit' => $receiptAmount->amount,
                            'credit' => 0,
                            'balance' => 0,
                        ];
                    }
                } else if ($section == "exchange") {

                }
                $this->reportData->push([
                    'id' => $entry->id,
                    'model' => $model,
                    'section' => $section,
                    'user' => User::find($entry->user_id),
                    'name' => $entry->name,
                    'amount' => $entry->amount,
                    'paid_by' => $entry->paid_by,
                    'from_till_id' => Till::find($entry->from_till_id),
                    'to_till_id' => Till::find($entry->to_till_id),
                    'date' => $entry->created_at,
                    'category' => Category::find($entry->category_id),
                    'sub_category' => SubCategory::find($entry->sub_category_id),
                    'description' => $entry->description,
                    'amounts' => $amounts,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.pcash.report-view');
    }
}
