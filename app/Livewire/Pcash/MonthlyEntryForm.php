<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Currency;
use App\Models\MonthlyEntry;
use App\Models\MonthlyEntryAmount;
use App\Models\Till;
use App\Models\TillAmount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

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
    public $pending;
    public $confirm;


    public  $monthlyEntryAmounts = [];
    public $monthlyEntry_id;
    public $currency_id;
    public $amount;
    public $closing_amount;


    public $tills;
    public $tillAmounts = [];

    public $monthlyEntryAmouts = [];

    public $currencies;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('monthlyEntry-list');

        $this->status=$status;
        // $this->addRow();

        $this->tills = Till::when(!auth()->user()->hasPermissionTo('till-viewAll'), function ($query) {
            $query->where('user_id', auth()->id());
        })->with('tillAmounts')->get();

        $this->currencies = Currency::all();

        if ($id) {
            $this->monthlyEntry_id=$id;
            $this->editing = true;
            $this->monthlyEntry = MonthlyEntry::findOrFail($id);

            $this->user_id = $this->monthlyEntry->user_id;
            $this->created_by = $this->monthlyEntry->created_by;
            $this->till_id = $this->monthlyEntry->till_id;

            $this->open_date = $this->monthlyEntry->open_date;
            $this->close_date = $this->monthlyEntry->close_date;
            $this->pending = $this->monthlyEntry->pending;
            $this->confirm = $this->monthlyEntry->confirm;

        

            $this->tillAmounts = MonthlyEntryAmount::with(['currency', 'monthlyEntry'])->whereHas('monthlyEntry', function ($query) {
                $query->where('till_id', $this->till_id)->where('monthly_entry_id', $this->monthlyEntry_id);
            })->get() ;




            $this->monthlyEntryAmounts = [];
            foreach ($this->monthlyEntry->monthlyEntryAmounts as $monthlyEntryAmount) {
                $this->monthlyEntryAmounts[] = [
                    'id' => $monthlyEntryAmount->id,
                    'amount' => number_format($monthlyEntryAmount->amount),
                    'closing_amount' => number_format($monthlyEntryAmount->closing_amount),

                    'currency_id' => $monthlyEntryAmount->currency_id,
                ];
            }

        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['nullable'],
            'created_by' => ['nullable'],
            'till_id' => ['required', 'integer'],


            'pending' => ['nullable'],
            'confirm' => ['nullable'],


            'monthlyEntryAmounts' => ['array'],
            'monthlyEntryAmounts.*.monthlyEntry_id' => ['nullable'],
            'monthlyEntryAmounts.*.currency_id' => ['nullable'],
            'monthlyEntryAmounts.*.amount' => ['nullable'],
        ];
        if ($this->editing) {
            $rules['open_date'] = ['nullable', 'date'];
            $rules['close_date'] = ['required', 'date'];
            $rules['monthlyEntryAmounts.*.closing_amount'] = ['required'];
        } else {
            $rules['open_date'] = ['required', 'date'];
            $rules['close_date'] = ['nullable', 'date'];
            $rules['monthlyEntryAmounts.*.closing_amount'] = ['nullable'];
        }
        

        return $rules;
    }

    #[On('getTillAmounts')]
    public function getTillAmounts()
    {
        $this->tillAmounts = [];
        $this->monthlyEntryAmouts = [];
        $this->monthlyEntryAmouts = MonthlyEntryAmount::with(['currency', 'monthlyEntry'])->whereHas('monthlyEntry', function ($query) {
            $query->where('till_id', $this->till_id);
        })->get(); 


            if($this->monthlyEntryAmouts->count() === 0){
                $this->tillAmounts = TillAmount::where('till_id', $this->till_id)->with('currency')->get();
            }else{
                $this->tillAmounts = $this->monthlyEntryAmouts;
                }
}
    

    public function addRow()
    {
        $this->monthlyEntryAmounts[] = ['currency_id' => '','amount' => '','closing_amount'=>''];
    }


    public function removeRow($key)
    {
        unset($this->monthlyEntryAmounts[$key]);
    }

    public function store()
    {


        $this->authorize('monthlyEntry-create');

        $this->validate();


            $monthlyEntry = MonthlyEntry::create([
                'user_id' => auth()->id(),
                'created_by' => auth()->id(),
                'till_id' => $this->till_id,

                'open_date' => $this->open_date,
                'close_date' => null,
                'pending' => 0,
                'confirm' => 0,

            ]);



                $monthlyEntry_id = $monthlyEntry->id;
            
                foreach ($this->tillAmounts as $tillAmount) {
            
                 MonthlyEntryAmount::create([
                    'monthly_entry_id' => $monthlyEntry_id,
                    'currency_id' => $tillAmount->currency_id,
                    'amount' => sanitizeNumber($tillAmount->amount),
                    
                ]);
           
            }
        
            

        return to_route('monthlyEntry')->with('success', 'monthlyEntry has been created successfully!');
    }



    public function update()
    {
        $this->authorize('monthlyEntry-edit');
        $this->validate();

    
            $this->monthlyEntry->update([

                'till_id' => $this->till_id,
                'open_date' => $this->open_date,
                'close_date' => $this->close_date,
                'pending' => 1,
                'confirm' => 0,
            ]);

            foreach ($this->monthlyEntryAmounts as $monthlyEntryAmount) {

                 MonthlyEntryAmount::updateOrCreate([
                    'id' => $monthlyEntryAmount['id'] ?? 0,
                ],[
                    'monthly_entry_id' => $this->monthlyEntry_id,
                    'amount' => sanitizeNumber($monthlyEntryAmount['amount']),
                    'currency_id' => $monthlyEntryAmount['currency_id'],
                    'closing_amount' => sanitizeNumber($monthlyEntryAmount['closing_amount']),
                ]);

  

                $updatedTillAmounts = TillAmount::where('till_id', $this->till_id)->where('currency_id', $monthlyEntryAmount['currency_id'])->first();
                $updatedTillAmounts->update([
                    'amount' => $updatedTillAmounts->amount + sanitizeNumber($monthlyEntryAmount['closing_amount']),
                ]);
            }
            
            




            return to_route('monthlyEntry')->with('success', 'monthlyEntry has been updated successfully!');
        }
        




    public function render()
    {

        return view('livewire.pcash.monthlyEntry-form');
    }
}
