<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\Exchange;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ExchangeForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $exchange;

    public $currencies;

    public $user_id;
    public $from_currency_id;
    public $to_currency_id;
    public $amount;
    public $rate;
    public $description;
    public $result;

    public $from_currency_list;
    public $to_currency_list;


    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('exchange-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;

        $this->currencies = Currency::all();

        if ($id) {
            $this->editing = true;
            $this->exchange = Exchange::findOrFail($id);

            $this->user_id = $this->exchange->user_id;
            $this->from_currency_id = $this->exchange->from_currency_id;
            $this->to_currency_id = $this->exchange->to_currency_id;
            $this->amount = number_format($this->exchange->amount);
            $this->rate = number_format($this->exchange->rate);
            $this->description = $this->exchange->description;
            $this->result = number_format($this->exchange->result);
        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['nullable'],
            'from_currency_id' => ['required', 'integer'],
            'to_currency_id' => ['required', 'integer'],
            'amount' => ['required'],
            'rate' => ['required'],
            'description' => ['nullable', 'string'],
            'result' => ['nullable'],

        ];

        return $rules;
    }

    public function emptyAmountsFields(){
        $this->amount="";
        $this->result="";
        $this->rate="";
    }

    public function calculateResult(){

        if(!isset($this->from_currency_list) || !isset($this->to_currency_list)){
            return;
        }

        $this->amount=$this->sanitizeNumber($this->amount);
        $this->result=$this->sanitizeNumber($this->result);
        $this->rate=$this->sanitizeNumber($this->rate);
        
        if( $this->amount>0 && $this->result>0 && $this->rate==""){
            if($this->from_currency_list->list_order < $this->to_currency_list->list_order){
                $this->rate=round($this->result/$this->amount,2);
            }
            elseif($this->from_currency_list->list_order > $this->to_currency_list->list_order){
                $this->rate=round($this->amount/$this->result,2);
            }
        }
        else if($this->result>0 && $this->rate>0 && $this->amount==""){
            if($this->from_currency_list->list_order < $this->to_currency_list->list_order){
                $this->amount=$this->result/$this->rate;
            }
            elseif($this->from_currency_list->list_order > $this->to_currency_list->list_order){
                $this->amount=$this->result*$this->rate;
            }
        }
        else if($this->amount>0 && $this->rate>0){
            if($this->from_currency_list->list_order < $this->to_currency_list->list_order){
                $this->result=round($this->amount*$this->rate,2);
            }
            elseif($this->from_currency_list->list_order > $this->to_currency_list->list_order){
                $this->result=round($this->amount/$this->rate,2);
            }
        }

    }


    private function sanitizeNumber($number)
    {
        $number = str_replace(',', '', $number);
        if (substr($number, -1) === '.') {
            $number = substr($number, 0, -1);
        }

        return $number;
    }

    public function store()
    {

        $this->authorize('exchange-edit');

        $this->validate();

        Exchange::create([
            'user_id' => auth()->id() ,
            'from_currency_id' => $this->from_currency_id ,

            'to_currency_id' => $this->to_currency_id ,
            'amount' => $this->sanitizeNumber($this->amount) ,
            'rate' => $this->sanitizeNumber($this->rate) ,
            'description' => $this->description ,
            'result' => $this->sanitizeNumber($this->result) ,
        ]);

        session()->flash('success', 'exchange has been created successfully!');

        return redirect()->route('exchange');
    }


    public function update()
    {
        $this->authorize('exchange-edit');

        $this->validate();

        $this->exchange->update([
            'from_currency_id' => $this->from_currency_id ,
            'to_currency_id' => $this->to_currency_id ,
            'amount' => $this->sanitizeNumber($this->amount),
            'rate' => $this->sanitizeNumber($this->rate),
            'description' => $this->description ,
            'result' => $this->sanitizeNumber($this->result),

        ]);

        session()->flash('success', 'exchange has been updated successfully!');

        return redirect()->route('exchange');
    }
    

    public function render()
    {  
        $this->from_currency_list = Currency::find($this->from_currency_id);
        $this->to_currency_list = Currency::find($this->to_currency_id);

        return view('livewire.pcash.exchange-form');
    }
}
