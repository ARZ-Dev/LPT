<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\Till;
use App\Models\TillAmount;
use App\Models\User;
use App\Utils\Constants;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class TillForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;
    public $roles;
    public $till;
    public $user_id;
    public $name;
    public $tillAmounts = [];
    public $users = [];
    public $currencies = [];

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('till-list');

        $this->users = User::all();
        $this->currencies = Currency::all();

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();

        if ($id) {
            $this->editing = true;
            $this->till = Till::with(['tillAmount' => ['currency']])->findOrFail($id);

            $this->user_id = $this->till->user_id;
            $this->name = $this->till->name;

            $this->tillAmounts = [];
            foreach ($this->till->tillAmount as $tillAmount) {
                $this->tillAmounts[] = [
                    'id' => $tillAmount->id,
                    'amount' => number_format($tillAmount->amount),
                    'currency_id' => $tillAmount->currency_id,
                    'currency_name' => $tillAmount->currency?->name,
                ];
            }
        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'tillAmounts' => ['array'],
            'tillAmounts.*.till_id' => ['nullable'],
            'tillAmounts.*.currency_id' => ['required', 'distinct'],
            'tillAmounts.*.amount' => ['required'],
        ];

        return $rules;
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

    private function sanitizeNumber($number)
    {
        $number = str_replace(',', '', $number);
        if (str_ends_with($number, '.')) {
            $number = substr($number, 0, -1);
        }

        return $number;
    }



    public function store()
    {
        $this->authorize('till-edit');

        $this->validate();

        $till=Till::create([
            'user_id' => $this->user_id ,
            'name' => $this->name ,
        ]);

        $tillId = $till->id;
        foreach ($this->tillAmounts as $tillAmount) {
            TillAmount::create([
                'till_id' => $tillId,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => $this->sanitizeNumber($tillAmount['amount']),
            ]);
        }

        session()->flash('success', 'till has been created successfully!');

        return redirect()->route('till');
    }

    public function update()
    {
        $this->authorize('till-edit');

        $this->validate();

        $this->till->update([
            'user_id' => $this->user_id ,
            'name' => $this->name ,
        ]);

        $tillAmountsIds = [];
        foreach ($this->tillAmounts as $tillAmount) {

            $amount = TillAmount::updateOrCreate([
                'id' => $tillAmount['id'] ?? 0,
            ],[
                'till_id' => $this->till->id,
                'currency_id' => $tillAmount['currency_id'],
                'amount' => $this->sanitizeNumber($tillAmount['amount']),
            ]);

            $tillAmountsIds[] = $amount->id;
        }

        TillAmount::where('till_id', $this->till->id)->whereNotIn('id', $tillAmountsIds)->delete();

        session()->flash('success', 'till has been updated successfully!');

        return redirect()->route('till');
    }




    public function render()
    {
        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.tills.till-view');
        }
        return view('livewire.pcash.tills.till-form');
    }
}
