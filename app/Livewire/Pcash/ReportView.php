<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\MonthlyEntry;
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

        $monthlyEntries = MonthlyEntry::with(['user', 'monthlyEntryAmounts'])
            ->where('till_id', $this->tillId)
            ->when($this->filterByDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
            })
            ->get();

        $payments = Payment::with(['user', 'paymentAmounts', 'category', 'subCategory'])
            ->where('till_id', $this->tillId)
            ->when($this->filterByDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
            })
            ->get();

        $receipts = Receipt::with(['user', 'receiptAmounts', 'category', 'subCategory'])
            ->where('till_id', $this->tillId)
            ->when($this->filterByDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
            })
            ->get();

        $transfers = Transfer::with(['user', 'transferAmounts'])
            ->where(function ($query) {
                $query->where('from_till_id', $this->tillId)->orWhere('to_till_id', $this->tillId);
            })
            ->when($this->filterByDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
            })
            ->get();

        $exchanges = Exchange::with(['user'])
            ->where('till_id', $this->tillId)
            ->when($this->filterByDate, function ($query) {
                $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
            })
            ->get();

        $data = $payments->merge($receipts)->merge($transfers)->merge($exchanges)->merge($monthlyEntries);
        $data = $data->sortBy('created_at');

        $amounts = [];
        $this->reportData = collect();
        foreach ($data as $entry) {

            $section = "";
            if ($entry instanceof MonthlyEntry) {
                $section = "Monthly Entry";

                $currenciesIds = $entry->monthlyEntryAmounts()->pluck('currency_id')->toArray();
                $otherCurrenciesIds = array_diff($this->currencies->pluck('id')->toArray(), $currenciesIds);
                foreach ($entry->monthlyEntryAmounts as $monthlyEntryAmount) {
                    $balance = ($amounts[$monthlyEntryAmount->currency_id]['balance'] ?? 0) + ($entry->close_date ? $monthlyEntryAmount->closing_amount : $monthlyEntryAmount->amount);
                    $amounts[$monthlyEntryAmount->currency_id] = [
                        'debit' => ($entry->close_date ? $monthlyEntryAmount->closing_amount : $monthlyEntryAmount->amount),
                        'credit' => 0,
                        'balance' => $balance,
                    ];
                }
                foreach ($otherCurrenciesIds as $otherCurrencyId) {
                    $amounts[$otherCurrencyId]['debit'] = 0;
                    $amounts[$otherCurrencyId]['credit'] = 0;
                }

            } else if ($entry instanceof Payment) {
                $section = "Payment";

                $currenciesIds = $entry->paymentAmounts()->pluck('currency_id')->toArray();
                $otherCurrenciesIds = array_diff($this->currencies->pluck('id')->toArray(), $currenciesIds);
                foreach ($entry->paymentAmounts as $paymentAmount) {
                    $balance = ($amounts[$paymentAmount->currency_id]['balance'] ?? 0) - $paymentAmount->amount;
                    $amounts[$paymentAmount->currency_id] = [
                        'debit' => 0,
                        'credit' => $paymentAmount->amount,
                        'balance' => $balance,
                    ];
                }
                foreach ($otherCurrenciesIds as $otherCurrencyId) {
                    $amounts[$otherCurrencyId]['debit'] = 0;
                    $amounts[$otherCurrencyId]['credit'] = 0;
                }

            } else if ($entry instanceof Receipt) {
                $section = "Receipt";

                $currenciesIds = $entry->receiptAmounts()->pluck('currency_id')->toArray();
                $otherCurrenciesIds = array_diff($this->currencies->pluck('id')->toArray(), $currenciesIds);
                foreach ($entry->receiptAmounts as $receiptAmount) {
                    $balance = ($amounts[$receiptAmount->currency_id]['balance'] ?? 0) + $receiptAmount->amount;
                    $amounts[$receiptAmount->currency_id] = [
                        'debit' => $receiptAmount->amount,
                        'credit' => 0,
                        'balance' => $balance,
                    ];
                }
                foreach ($otherCurrenciesIds as $otherCurrencyId) {
                    $amounts[$otherCurrencyId]['debit'] = 0;
                    $amounts[$otherCurrencyId]['credit'] = 0;
                }

            } else if ($entry instanceof Transfer) {
                $section = "Transfer";

                $currenciesIds = $entry->transferAmounts()->pluck('currency_id')->toArray();
                $otherCurrenciesIds = array_diff($this->currencies->pluck('id')->toArray(), $currenciesIds);
                foreach ($entry->transferAmounts as $transferAmount) {
                    if ($entry->from_till_id == $this->tillId) {
                        $balance = ($amounts[$transferAmount->currency_id]['balance'] ?? 0) - $transferAmount->amount;
                    } else {
                        $balance = ($amounts[$transferAmount->currency_id]['balance'] ?? 0) + $transferAmount->amount;
                    }
                    $amounts[$transferAmount->currency_id] = [
                        'debit' => $entry->from_till_id == $this->tillId ? 0 : $transferAmount->amount,
                        'credit' => $entry->from_till_id == $this->tillId ? $transferAmount->amount : 0,
                        'balance' => $balance,
                    ];
                }
                foreach ($otherCurrenciesIds as $otherCurrencyId) {
                    $amounts[$otherCurrencyId]['debit'] = 0;
                    $amounts[$otherCurrencyId]['credit'] = 0;
                }

            } else if ($entry instanceof Exchange) {
                $section = "Exchange";

                $amounts[$entry->from_currency_id] = [
                    'debit' => 0,
                    'credit' => $entry->amount,
                    'balance' => ($amounts[$entry->from_currency_id]['balance'] ?? 0) - $entry->amount,
                ];
                $amounts[$entry->to_currency_id] = [
                    'debit' => $entry->result,
                    'credit' => 0,
                    'balance' => ($amounts[$entry->to_currency_id]['balance'] ?? 0) + $entry->result,
                ];
            }

            $this->reportData->push([
                'id' => $entry->id,
                'section' => $section,
                'section_id' => $section[0] . " #" . $entry->id,
                'user' => User::find($entry->user_id),
                'name' => $entry->name,
                'amount' => $entry->amount,
                'paid_by' => $entry->paid_by,
                'date' => $entry->created_at,
                'category' => $entry->category,
                'sub_category' => $entry->subCategory,
                'description' => $entry->description,
                'amounts' => $amounts,
                'till_id' => $entry->till_id,
                'till' => $entry->till,
                'till_user' => $entry->till?->user,
                'from_till' => $entry->fromTill,
                'to_till' => $entry->toTill,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pcash.report-view');
    }
}
