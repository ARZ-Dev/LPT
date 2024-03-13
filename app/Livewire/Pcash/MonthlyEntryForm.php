<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\MonthlyEntry;
use App\Models\MonthlyEntryAmount;
use App\Models\Till;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use App\Utils\Constants;

class MonthlyEntryForm extends Component
{
    use AuthorizesRequests ;

    public $editing = false;
    public int $status;

    public $monthlyEntry;

    public $user_id;
    public $created_by;
    public $till_id;

    public $open_date;
    public $close_date;

    public  $monthlyEntryAmounts = [];
    public $monthlyEntry_id;
    public $currency_id;
    public $amount;


    public $tills;
    public $tillAmounts = [];

    public $currencies;

    public $selectedTill;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('monthlyEntry-list');

        $this->status=$status;

        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('tillAmounts', 'monthlyEntries', 'user')
            ->whereDoesntHave('openedMonthlyEntries')
            ->get();

        $this->open_date = now()->startOfMonth()->format('Y-m');

        if ($id) {
            $this->monthlyEntry_id=$id;
            $this->editing = true;
            $this->monthlyEntry = MonthlyEntry::with('monthlyEntryAmounts','user','till.tillAmounts')->findOrFail($id);

            $this->user_id = $this->monthlyEntry->user_id;
            $this->created_by = $this->monthlyEntry->created_by;
            $this->till_id = $this->monthlyEntry->till_id;
            $this->selectedTill = Till::with('user')->findOrFail($this->till_id);

            $this->open_date = $this->monthlyEntry->open_date;
            $this->close_date = $this->monthlyEntry->close_date ?? Carbon::parse($this->monthlyEntry->open_date)->endOfMonth()->format("Y-m");

            $this->getTillAmounts();

            $this->monthlyEntryAmounts = [];
            foreach ($this->monthlyEntry->monthlyEntryAmounts as $monthlyEntryAmount) {
                $this->monthlyEntryAmounts[] = [
                    'id' => $monthlyEntryAmount->id,
                    'amount' => number_format($monthlyEntryAmount->amount, 2),
                    'closing_amount' => number_format($monthlyEntryAmount->closing_amount, 2),
                    'currency_id' => $monthlyEntryAmount->currency_id,
                ];
            }

        }

    }

    protected function rules()
    {
        $rules = [
            'till_id' => ['required', 'integer'],
            'monthlyEntryAmounts' => ['array'],
            'monthlyEntryAmounts.*.monthlyEntry_id' => ['nullable'],
            'monthlyEntryAmounts.*.currency_id' => ['nullable'],
            'monthlyEntryAmounts.*.amount' => ['nullable'],
        ];
        if ($this->editing) {
            $rules['close_date'] = ['required', 'date', 'after_or_equal:open_date'];
            $rules['monthlyEntryAmounts.*.closing_amount'] = ['required'];
        } else {
            $rules['open_date'] = ['required', 'date'];
        }


        return $rules;
    }

    #[On('getTillAmounts')]
    public function getTillAmounts()
    {
        $this->tillAmounts = [];
        $tillAmounts = TillAmount::where('till_id', $this->till_id)->with('currency')->get();
        foreach ($tillAmounts as $tillAmount) {
            $this->tillAmounts[] = [
                'id' => $tillAmount->id,
                'currency' => $tillAmount->currency,
                'currency_id' => $tillAmount->currency_id,
                'amount' => number_format($tillAmount->amount, 2),
                'closing_amount' => number_format($tillAmount->amount, 2)
            ];
        }
    }

    public function store()
    {
        $this->authorize('monthlyEntry-create');
        $this->validate();

        DB::beginTransaction();
        try {

            // check if there is an existing monthly entry for the selected month
            $openDate = Carbon::parse($this->open_date)->startOfMonth();
            $existingMonthlyEntry = MonthlyEntry::where('till_id', $this->till_id)->where('open_date', $openDate->toDateString())->first();
            throw_if($existingMonthlyEntry, new \Exception("Cannot open the same month twice for the same till!"));

            $monthlyEntry = MonthlyEntry::create([
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
                'till_id' => $this->till_id,
                'open_date' => $openDate->toDateString(),
            ]);

            foreach ($this->tillAmounts as $tillAmount) {
                 MonthlyEntryAmount::create([
                    'monthly_entry_id' => $monthlyEntry->id,
                    'currency_id' => $tillAmount['currency_id'],
                    'amount' => sanitizeNumber($tillAmount['amount']),
                    'closing_amount' => sanitizeNumber($tillAmount['amount']),
                 ]);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('monthlyEntry')->with('success', 'monthlyEntry has been created successfully!');
    }

    public function update()
    {
        $this->authorize('monthlyEntry-edit');
        $this->validate();

        DB::beginTransaction();
        try {

            // check if there is an existing monthly entry for the selected month
            $closeDate = Carbon::parse($this->close_date)->endOfMonth();
            $existingMonthlyEntry = MonthlyEntry::where('till_id', $this->till_id)->where('close_date', $closeDate->toDateString())->first();
            throw_if($existingMonthlyEntry, new \Exception("Cannot close the same month twice for the same till!"));

            $this->monthlyEntry->update([
                'close_date' => $closeDate->toDateString(),
            ]);

            // opening a new monthly entry for the next month
            $newMonthlyEntry = MonthlyEntry::create([
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
                'till_id' => $this->till_id,
                'open_date' => $closeDate->addDay()->toDateString(),
            ]);

            $monthlyEntryAmountsIds = [];
            foreach ($this->tillAmounts as $tillAmount) {
                $amount = MonthlyEntryAmount::updateOrCreate([
                    'monthly_entry_id' => $this->monthlyEntry->id,
                    'currency_id' => $tillAmount['currency_id'],
                ],[
                    'amount' => sanitizeNumber($tillAmount['amount']),
                    'closing_amount' => sanitizeNumber($tillAmount['closing_amount']),
                ]);
                $monthlyEntryAmountsIds[] = $amount->id;

                $updatedTillAmounts = TillAmount::where('till_id', $this->till_id)->where('currency_id', $tillAmount['currency_id'])->first();

                if ($updatedTillAmounts) {
                    $updatedTillAmounts->update([
                        'amount' => sanitizeNumber($tillAmount['closing_amount']),
                    ]);
                }

                // opening a new monthly entry amounts for the next month
                MonthlyEntryAmount::create([
                    'monthly_entry_id' => $newMonthlyEntry->id,
                    'currency_id' => $tillAmount['currency_id'],
                    'amount' => sanitizeNumber($tillAmount['closing_amount']),
                    'closing_amount' => sanitizeNumber($tillAmount['closing_amount']),
                ]);
            }
            MonthlyEntryAmount::where('monthly_entry_id', $this->monthlyEntry->id)->whereNotIn('id', $monthlyEntryAmountsIds)->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('monthlyEntry')->with('success', 'Monthly entry has been closed successfully!');
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.monthlyEntry.monthlyEntry-view');
        }
        return view('livewire.pcash.monthlyEntry.monthlyEntry-form');
    }
}
