<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\Exchange;
use App\Models\Till;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ExchangeForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $tills = [];
    public $exchange;

    public $currencies;

    public int $till_id;
    public $user_id;
    public $from_currency_id;
    public $to_currency_id;
    public $amount;
    public $rate;
    public $description;
    public $result;
    public $fromCurrency;
    public $toCurrency;


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('exchange-list');

        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->get();
        
        $this->status = $status;

        $this->currencies = Currency::all();

        if ($id) {
            $this->editing = true;
            $this->exchange = Exchange::findOrFail($id);

            $this->user_id = $this->exchange->user_id;
            $this->till_id = $this->exchange->till_id;
            $this->from_currency_id = $this->exchange->from_currency_id;
            $this->fromCurrency = Currency::find($this->from_currency_id);
            $this->to_currency_id = $this->exchange->to_currency_id;
            $this->toCurrency = Currency::find($this->to_currency_id);
            $this->amount = number_format($this->exchange->amount);
            $this->rate = number_format($this->exchange->rate);
            $this->result = number_format($this->exchange->result);
            $this->description = $this->exchange->description;
        }

    }

    protected function rules()
    {
        $rules = [
            'till_id' => ['required'],
            'from_currency_id' => ['required', 'integer'],
            'to_currency_id' => ['required', 'integer'],
            'amount' => ['required'],
            'rate' => ['required'],
            'description' => ['nullable', 'string'],
            'result' => ['nullable'],
        ];

        return $rules;
    }

    public function updatedFromCurrencyId($value)
    {
        $this->fromCurrency = Currency::find($value);
    }

    public function updatedToCurrencyId($value)
    {
        $this->toCurrency = Currency::find($value);
    }

    public function emptyAmountsFields()
    {
        if($this->from_currency_id == $this->to_currency_id){
            $this->to_currency_id="";
            $this->dispatch('emptyToCurrencyId');
        }
        $this->amount="";
        $this->result="";
        $this->rate="";
    }

    public function calculateResult($type)
    {
        if (!isset($this->fromCurrency, $this->toCurrency)) {
            return;
        }

        $amount = sanitizeNumber($this->amount);
        $result = sanitizeNumber($this->result);
        $rate = sanitizeNumber($this->rate);

        if (($type == "rate" || $type == "amount") && $amount > 0 && $rate > 0) {
            if ($this->fromCurrency->list_order < $this->toCurrency->list_order) {
                $this->result = number_format($amount * $rate);
            } else if ($this->fromCurrency->list_order > $this->toCurrency->list_order) {
                $this->result = number_format($amount / $rate);
            }
        }

        if ($type == "result" && $result > 0 && $rate > 0) {
            if ($this->fromCurrency->list_order < $this->toCurrency->list_order) {
                $this->amount = number_format($result / $rate);
            } else if ($this->fromCurrency->list_order > $this->toCurrency->list_order) {
                $this->amount = number_format($result * $rate);
            }
        }

    }

    public function store()
    {
        $this->authorize('exchange-create');

        $this->validate();

        DB::beginTransaction();
        try {
            Exchange::create([
                'user_id' => auth()->id(),
                'till_id' => $this->till_id,
                'from_currency_id' => $this->from_currency_id,
                'to_currency_id' => $this->to_currency_id,
                'amount' => sanitizeNumber($this->amount),
                'rate' => sanitizeNumber($this->rate),
                'description' => $this->description,
                'result' => sanitizeNumber($this->result),
            ]);

            $this->updateTillsAmounts();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('exchange')->with('success', 'Exchange has been created successfully!');
    }


    public function update()
    {
        $this->authorize('exchange-edit');
        $this->validate();

        DB::beginTransaction();
        try {

            $fromTillAmount = TillAmount::where('till_id', $this->exchange->till_id)->where('currency_id', $this->exchange->from_currency_id)->first();
            $toTillAmount = TillAmount::where('till_id', $this->exchange->till_id)->where('currency_id', $this->exchange->to_currency_id)->first();
            throw_if(!$fromTillAmount, new \Exception("Selected currency from does not exists in till amounts!"));
            throw_if(!$toTillAmount, new \Exception("Selected currency to does not exists in till amounts!"));

            $fromTillAmount->update([
                'amount' => $fromTillAmount->amount - $this->exchange->amount,
            ]);

            $toTillAmount->update([
                'amount' => $toTillAmount->amount + $this->exchange->result,
            ]);

            $this->exchange->update([
                'till_id' => $this->till_id ,
                'from_currency_id' => $this->from_currency_id ,
                'to_currency_id' => $this->to_currency_id ,
                'amount' => sanitizeNumber($this->amount),
                'rate' => sanitizeNumber($this->rate),
                'description' => $this->description ,
                'result' => sanitizeNumber($this->result),
            ]);

            $this->updateTillsAmounts();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }

        return to_route('exchange')->with('success', 'Exchange has been updated successfully!');
    }

    /**
     * @return void
     * @throws \Throwable
     */
    public function updateTillsAmounts(): void
    {
        $fromTillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id', $this->from_currency_id)->first();
        $toTillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id', $this->to_currency_id)->first();

        throw_if(!$toTillAmount, new \Exception("Selected currency to does not exists in till amounts!"));

        $toTillAmount->update([
            'amount' => $toTillAmount->amount - sanitizeNumber($this->result),
        ]);

        if ($fromTillAmount) {
            $fromTillAmount->update([
                'amount' => $fromTillAmount->amount + sanitizeNumber($this->amount),
            ]);
        } else {
            TillAmount::create([
                'till_id' => $this->till_id,
                'currency_id' => $this->from_currency_id,
                'amount' => sanitizeNumber($this->amount),
            ]);
        }
    }


    public function render()
    {
        return view('livewire.pcash.exchange-form');
    }
}
