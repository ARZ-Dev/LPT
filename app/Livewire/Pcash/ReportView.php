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

        $amounts = [];
        foreach ($tables as $section => $model) {

            $entries = $model::with(['user'])->get();

            foreach ($entries as $entry) {

                if ($section == "payment") {
                    foreach ($entry->paymentAmounts as $paymentAmount) {
                        $balance = ($amounts[$entry->till_id][$paymentAmount->currency_id]['balance'] ?? 0) - $paymentAmount->amount;
                        $amounts[$entry->till_id][$paymentAmount->currency_id] = [
                            'debit' => 0,
                            'credit' => $paymentAmount->amount,
                            'balance' => $balance,
                        ];
                    }
                } else if ($section == "transfer") {

                } else if ($section == "receipt") {
                    foreach ($entry->receiptAmounts as $receiptAmount) {
                        $balance = ($amounts[$entry->till_id][$receiptAmount->currency_id]['balance'] ?? 0) + $receiptAmount->amount;
                        $amounts[$entry->till_id][$receiptAmount->currency_id] = [
                            'debit' => $receiptAmount->amount,
                            'credit' => 0,
                            'balance' => $balance,
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
                    'date' => $entry->created_at,
                    'category' => Category::find($entry->category_id),
                    'sub_category' => SubCategory::find($entry->sub_category_id),
                    'description' => $entry->description,
                    'amounts' => $amounts,
                    'till_id' => $entry->till_id,
                    'till' => $entry->till,
                    'till_user' => $entry->till?->user,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.pcash.report-view');
    }
}
