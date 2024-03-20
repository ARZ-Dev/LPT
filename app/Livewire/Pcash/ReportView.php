<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\Exchange;
use App\Models\MonthlyEntryAction;
use App\Models\MonthlyEntry;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\SubCategory;
use App\Models\Till;
use App\Models\Transfer;
use App\Models\User;
use App\Utils\Constants;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Validation\Rules\RequiredIf;
use Livewire\Component;

class ReportView extends Component
{
    use AuthorizesRequests;

    public $reportData = [];
    public $currencies = [];
    public $tills = [];
    public array $tillIds = [];
    public bool $filterByDate = false;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->authorize('pettyCashSummary-view');

        $this->tills = Till::with(['user'])
            ->when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();

        $this->currencies = Currency::all();
        $this->startDate = now()->startOfMonth()->format("Y-m-d");
        $this->endDate = now()->endOfMonth()->format("Y-m-d");

        if (count($this->tills) == 1) {
            $this->tillIds = [$this->tills[0]->id];
            $this->getReportData();
        }
    }

    public function rules()
    {
        return [
            'tillIds' => ['required', 'array', 'min:1'],
            'startDate' => [new RequiredIf($this->filterByDate), 'date'],
            'endDate' => [new RequiredIf($this->filterByDate), 'date', 'after_or_equal:startDate'],
        ];
    }

    public function getReportData()
    {
        $this->validate();

        $this->reportData = [];
        $usedCurrenciesIds = [];

        foreach ($this->tillIds as $tillId) {

            $monthlyActions = MonthlyEntryAction::with([
                    'monthlyEntry.user', 'monthlyEntry.monthlyEntryAmounts', 'monthlyEntry.till' => ['user']
                ])
                ->whereHas('monthlyEntry', function ($query) use ($tillId) {
                    $query->where('till_id', $tillId);
                })
                ->when($this->filterByDate, function ($query) {
                    $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
                })
                ->get();

            $payments = Payment::with(['user', 'paymentAmounts', 'category', 'subCategory', 'till' => ['user']])
                ->where('till_id', $tillId)
                ->when($this->filterByDate, function ($query) {
                    $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
                })
                ->get();

            $receipts = Receipt::with(['user', 'receiptAmounts', 'category', 'subCategory', 'till' => ['user']])
                ->where('till_id', $tillId)
                ->when($this->filterByDate, function ($query) {
                    $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
                })
                ->get();

            $transfers = Transfer::with(['user', 'transferAmounts', 'fromTill' => ['user'], 'toTill' => ['user']])
                ->where(function ($query) use ($tillId) {
                    $query->where('from_till_id', $tillId)->orWhere('to_till_id', $tillId);
                })
                ->when($this->filterByDate, function ($query) {
                    $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
                })
                ->get();

            $exchanges = Exchange::with(['user', 'till' => ['user']])
                ->where('till_id', $tillId)
                ->when($this->filterByDate, function ($query) {
                    $query->whereBetween('created_at', [$this->startDate . " 00:00", $this->endDate . " 23:59"]);
                })
                ->get();

            $data = collect()
                ->concat($payments)
                ->concat($receipts)
                ->concat($transfers)
                ->concat($exchanges)
                ->concat($monthlyActions);
            $data = $data->sortBy('created_at');


            $amounts = [];
            foreach ($data as $entry) {

                $section = "";
                $sectionId = "";
                $url = "";
                $bgColor = "";
                if ($entry instanceof MonthlyEntryAction) {
                    $bgColor = "bg-light";
                    $section = "Monthly " . ucfirst($entry->action);
                    $sectionId = Carbon::parse($entry->monthlyEntry?->open_date)->format('M Y') . " " . ucfirst($entry->action);

                    $url = route('monthly-openings-closings.view', [$entry->monthlyEntry?->id, Constants::VIEW_STATUS]);

                    foreach ($entry->monthlyEntry?->monthlyEntryAmounts ?? [] as $monthlyEntryAmount) {
                        $amounts[$monthlyEntryAmount->currency_id] = [
                            'debit' => 0,
                            'credit' => 0,
                            'balance' => $entry->monthlyEntry?->close_date ? $monthlyEntryAmount->closing_amount : $monthlyEntryAmount->amount,
                        ];

                        if (!in_array($monthlyEntryAmount->currency_id, $usedCurrenciesIds)) {
                            $usedCurrenciesIds[] = $monthlyEntryAmount->currency_id;
                        }
                    }

                    $currenciesIds = $entry->monthlyEntry->monthlyEntryAmounts()->pluck('currency_id')->toArray();
                    $amounts = $this->clearOtherCurrencies($amounts, $currenciesIds);

                } else if ($entry instanceof Payment) {
                    $section = "Payment";
                    $sectionId = "Payment #" . $entry->id;
                    $url = route('payment.view', [$entry->id, Constants::VIEW_STATUS]);

                    foreach ($entry->paymentAmounts as $paymentAmount) {
                        $balance = ($amounts[$paymentAmount->currency_id]['balance'] ?? 0) - $paymentAmount->amount;
                        $amounts[$paymentAmount->currency_id] = [
                            'debit' => 0,
                            'credit' => $paymentAmount->amount,
                            'balance' => $balance,
                        ];

                        if (!in_array($paymentAmount->currency_id, $usedCurrenciesIds)) {
                            $usedCurrenciesIds[] = $paymentAmount->currency_id;
                        }
                    }

                    $currenciesIds = $entry->paymentAmounts()->pluck('currency_id')->toArray();
                    $amounts = $this->clearOtherCurrencies($amounts, $currenciesIds);

                } else if ($entry instanceof Receipt) {
                    $section = "Receipt";
                    $sectionId = "Receipt #" . $entry->id;
                    $url = route('receipt.view', [$entry->id, Constants::VIEW_STATUS]);

                    foreach ($entry->receiptAmounts as $receiptAmount) {
                        $balance = ($amounts[$receiptAmount->currency_id]['balance'] ?? 0) + $receiptAmount->amount;
                        $amounts[$receiptAmount->currency_id] = [
                            'debit' => $receiptAmount->amount,
                            'credit' => 0,
                            'balance' => $balance,
                        ];

                        if (!in_array($receiptAmount->currency_id, $usedCurrenciesIds)) {
                            $usedCurrenciesIds[] = $receiptAmount->currency_id;
                        }
                    }

                    $currenciesIds = $entry->receiptAmounts()->pluck('currency_id')->toArray();
                    $amounts = $this->clearOtherCurrencies($amounts, $currenciesIds);

                } else if ($entry instanceof Transfer) {
                    $section = "Transfer";
                    $sectionId = "Transfer #" . $entry->id;
                    $url = route('transfer.view', [$entry->id, Constants::VIEW_STATUS]);

                    foreach ($entry->transferAmounts as $transferAmount) {
                        if ($entry->from_till_id == $tillId) {
                            $balance = ($amounts[$transferAmount->currency_id]['balance'] ?? 0) - $transferAmount->amount;
                        } else {
                            $balance = ($amounts[$transferAmount->currency_id]['balance'] ?? 0) + $transferAmount->amount;
                        }
                        $amounts[$transferAmount->currency_id] = [
                            'debit' => $entry->from_till_id == $tillId ? 0 : $transferAmount->amount,
                            'credit' => $entry->from_till_id == $tillId ? $transferAmount->amount : 0,
                            'balance' => $balance,
                        ];

                        if (!in_array($transferAmount->currency_id, $usedCurrenciesIds)) {
                            $usedCurrenciesIds[] = $transferAmount->currency_id;
                        }
                    }

                    $currenciesIds = $entry->transferAmounts()->pluck('currency_id')->toArray();
                    $amounts = $this->clearOtherCurrencies($amounts, $currenciesIds);

                } else if ($entry instanceof Exchange) {
                    $section = "Exchange";
                    $sectionId = "Exchange #" . $entry->id;
                    $url = route('exchange.view', [$entry->id, Constants::VIEW_STATUS]);

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

                    if (!in_array($entry->from_currency_id, $usedCurrenciesIds)) {
                        $usedCurrenciesIds[] = $entry->from_currency_id;
                    }
                    if (!in_array($entry->to_currency_id, $usedCurrenciesIds)) {
                        $usedCurrenciesIds[] = $entry->to_currency_id;
                    }

                    $currenciesIds = [$entry->from_currency_id, $entry->to_currency_id];
                    $amounts = $this->clearOtherCurrencies($amounts, $currenciesIds);
                }

                $this->currencies = Currency::find($usedCurrenciesIds);

                $newEntry = [
                    'id' => $entry->id,
                    'section' => $section,
                    'section_id' => $sectionId,
                    'url' => $url,
                    'user' => $entry->user ?? $entry->monthlyEntry?->user,
                    'paid_by' => $entry->paid_by,
                    'paid_to' => $entry->paid_to,
                    'date' => $entry->created_at,
                    'category' => $entry->category,
                    'sub_category' => $entry->subCategory,
                    'description' => $entry->description,
                    'amounts' => $amounts,
                    'from_till' => $entry->fromTill,
                    'to_till' => $entry->toTill,
                    'bg_color' => $bgColor,
                    'till' => Till::with('user')->find($tillId),
                ];

                if (isset($this->reportData[$tillId])) {
                    $this->reportData[$tillId][] = $newEntry;
                } else {
                    $this->reportData[$tillId] = [$newEntry];
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.pcash.report-view');
    }

    /**
     * @param $amounts
     * @param $currenciesIds
     * @return array
     */
    public function clearOtherCurrencies($amounts, $currenciesIds): array
    {
        $otherCurrenciesIds = array_diff($this->currencies->pluck('id')->toArray(), $currenciesIds);
        foreach ($otherCurrenciesIds as $otherCurrencyId) {
            $amounts[$otherCurrencyId]['debit'] = 0;
            $amounts[$otherCurrencyId]['credit'] = 0;
        }
        return $amounts;
    }
}
