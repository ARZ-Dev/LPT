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

    public $reportData = [];
    public $currencies = [];
    public $tills = [];
    public int $tillId;
    public bool $filterByDate = false;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->tills = Till::all();
        $this->currencies = Currency::all();
        $this->startDate = now()->startOfMonth()->format("Y-m-d");
        $this->endDate = now()->endOfMonth()->format("Y-m-d");
    }

    public function rules()
    {
        return [
            'tillId' => ['required']
        ];
    }

    public function getReportData()
    {
        $this->validate();

        $tables = [
            'payment' => Payment::class,
            'receipt' => Receipt::class,
            'transfer' => Transfer::class,
            'exchange' => Exchange::class,
        ];

        $this->reportData = collect();

        $amounts = [];
        foreach ($tables as $section => $model) {

            $entries = $model::with(['user'])
                ->when($section == "transfer", function ($query) {
                    $query->where('from_till_id', $this->tillId)->orWhere('to_till_id', $this->tillId);
                })
                ->when($section != "transfer", function ($query) {
                    $query->where('till_id', $this->tillId);
                })
                ->when($this->filterByDate, function ($query) {
                    $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
                })
                ->orderBy('created_at')
                ->get();

            foreach ($entries as $entry) {

                switch ($section) {
                    case "payment":
                        foreach ($entry->paymentAmounts as $paymentAmount) {
                            $balance = ($amounts[$paymentAmount->currency_id]['balance'] ?? 0) - $paymentAmount->amount;
                            $amounts[$paymentAmount->currency_id] = [
                                'debit' => 0,
                                'credit' => $paymentAmount->amount,
                                'balance' => $balance,
                            ];
                        }
                        break;
                        
                    case "receipt":
                        foreach ($entry->receiptAmounts as $receiptAmount) {
                            $balance = ($amounts[$receiptAmount->currency_id]['balance'] ?? 0) + $receiptAmount->amount;
                            $amounts[$receiptAmount->currency_id] = [
                                'debit' => $receiptAmount->amount,
                                'credit' => 0,
                                'balance' => $balance,
                            ];
                        }
                        break;

                    case "exchange":
                        // @todo - exchange amounts calculation
                        break;
                    case "transfer":
                        // @todo - transfer amounts calculation
                        break;
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
