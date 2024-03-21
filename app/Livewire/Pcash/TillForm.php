<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\MonthlyEntry;
use App\Models\MonthlyEntryAction;
use App\Models\MonthlyEntryAmount;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\User;
use App\Utils\Constants;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;

class TillForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;
    public $till;
    public $created_by;
    public $user_id;

    public $name;
    public $tillAmounts = [];
    public $users = [];
    public $currencies = [];
    public bool $submitting = false;


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->users = User::when(!auth()->user()->hasPermissionTo('user-viewAll'), function ($query) {
                $query->where('id', auth()->id());
            })
            ->get();
        $this->currencies = Currency::all();

        $this->status=$status;
        $this->addRow();

        if ($id) {
            if ($status && $status == Constants::VIEW_STATUS) {
                $this->authorize('till-view');
            } else {
                $this->authorize('till-edit');
            }

            $this->editing = true;
            $this->till = Till::with(['tillAmounts' => ['currency']])->findOrFail($id);

            $this->authorize('view', $this->till);

            $this->created_by = $this->till->created_by;
            $this->user_id = $this->till->user_id;

            $this->name = $this->till->name;

            $this->tillAmounts = [];
            foreach ($this->till->tillAmounts as $tillAmount) {
                $this->tillAmounts[] = [
                    'id' => $tillAmount->id,
                    'amount' => number_format($tillAmount->amount, 2),
                    'currency_id' => $tillAmount->currency_id,
                    'currency_name' => $tillAmount->currency?->name,
                    'currency' => $tillAmount->currency,
                ];
            }
        } else {
            $this->authorize('till-create');

            if (count($this->users) == 1) {
                $this->user_id = $this->users[0]->id;
            }
        }

    }

    protected function rules()
    {
        return [
            'created_by' => ['nullable'],
            'user_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'tillAmounts' => ['array', 'min:1'],
            'tillAmounts.*.currency_id' => ['required', 'distinct'],
            'tillAmounts.*.amount' => ['required'],
        ];
    }

    public function addRow()
    {
        $this->tillAmounts[] = [
            'amount' => '',
            'currency_id' => '',
        ];
    }

    public function removeRow($key)
    {
        unset($this->tillAmounts[$key]);
    }

    public function store()
    {
        $this->authorize('till-edit');

        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $till = Till::create([
            'created_by' => auth()->id(),
            'user_id' => $this->user_id,
            'name' => $this->name,
        ]);

        $monthlyEntry = MonthlyEntry::create([
            'user_id' =>$this->user_id,
            'created_by' => auth()->id(),
            'till_id' => $till->id,
            'open_date' => Carbon::now()->startOfMonth(),
        ]);

        MonthlyEntryAction::create([
            'monthly_entry_id' => $monthlyEntry->id,
            'action' => 'opening',
        ]);

        foreach ($this->tillAmounts as $tillAmount) {
            MonthlyEntryAmount::create([
                'monthly_entry_id' => $monthlyEntry->id,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => sanitizeNumber($tillAmount['amount']),
            ]);

            TillAmount::create([
                'till_id' => $till->id,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => sanitizeNumber($tillAmount['amount']),
            ]);
        }

        return to_route('till')->with('success', 'Till has been created successfully!');
    }

    public function update()
    {
        $this->authorize('till-edit');

        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $this->till->update([
            'user_id' => $this->user_id,
            'name' => $this->name,
        ]);

        $tillAmountsIds = [];
        foreach ($this->tillAmounts as $tillAmount) {

            $amount = TillAmount::updateOrCreate([
                'id' => $tillAmount['id'] ?? 0,
            ],[
                'till_id' => $this->till->id,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => sanitizeNumber($tillAmount['amount']),
            ]);

            $tillAmountsIds[] = $amount->id;
        }

        TillAmount::where('till_id', $this->till->id)->whereNotIn('id', $tillAmountsIds)->delete();

        return to_route('till')->with('success', 'till has been updated successfully!');
    }

    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.tills.till-view');
        }
        return view('livewire.pcash.tills.till-form');
    }
}
