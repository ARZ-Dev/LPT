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

    public $tills;
    public $tillAmounts;



    public $currencies;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('monthlyEntry-list');

        $this->status=$status;
        // $this->addRow();

        $this->tills = Till::where('user_id',auth()->id())->get();

        $tillIds = $this->tills->pluck('id')->toArray();
        $this->tillAmounts = TillAmount::whereIn('till_id', $tillIds)->get();
       

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




            $this->monthlyEntryAmounts = [];
            foreach ($this->monthlyEntry->monthlyEntryAmounts as $monthlyEntryAmount) {
                $this->monthlyEntryAmounts[] = [
                    'id' => $monthlyEntryAmount->id,
                    'amount' => number_format($monthlyEntryAmount->amount),
                    'currency_id' => $monthlyEntryAmount->currency_id,
                ];
            }

            if (empty($this->monthlyEntryAmounts)) {
                $this->addRow();
            }
        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['nullable'],
            'created_by' => ['nullable'],
            'till_id' => ['required', 'integer'],

            'open_date' => ['nullable', 'date'],
            'close_date' => ['nullable', 'date'],
            'pending' => ['nullable'],
            'confirm' => ['nullable'],


            'monthlyEntryAmounts' => ['array'],
            'monthlyEntryAmounts.*.monthlyEntry_id' => ['nullable'],
            'monthlyEntryAmounts.*.currency_id' => ['required'],
            'monthlyEntryAmounts.*.amount' => ['required'],
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->monthlyEntryAmounts[] = ['currency_id' => '','amount' => ''];
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
            foreach ($this->monthlyEntryAmounts as $monthlyEntryAmount) {
                MonthlyEntryAmount::create([
                    'monthly_entry_id' => $monthlyEntry_id,
                    'currency_id' => $monthlyEntryAmount['currency_id'],
                    'amount' => sanitizeNumber($monthlyEntryAmount['amount']),
                ]);

                $tillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id',$monthlyEntryAmount['currency_id'])->first();

                $tillAmount->update([
                    'amount' => $tillAmount->amount - sanitizeNumber($monthlyEntryAmount['amount']),
                ]);
            }

        return to_route('monthlyEntry')->with('success', 'monthlyEntry has been created successfully!');
    }



    public function update()
    {
        $this->authorize('monthlyEntry-edit');
        $this->validate();


            $existingMonthlyEntryAmounts = MonthlyEntryAmount::where('monthly_entry_id', $this->monthlyEntry->id)->get();
            foreach ($existingMonthlyEntryAmounts as $existingMonthlyEntryAmount) {
                $tillAmount = TillAmount::where('till_id', $this->monthlyEntry->till_id)->where('currency_id', $existingMonthlyEntryAmount->currency_id)->first();

                if ($tillAmount) {
                    $updatedAmount = $tillAmount->amount + $existingMonthlyEntryAmount->amount;

                    $tillAmount->update([
                        'amount' => $updatedAmount,
                    ]);
                }

            }

            $this->monthlyEntry->update([

                'till_id' => $this->till_id,
                'open_date' => $this->open_date,
                'close_date' => $this->close_date,
                'pending' => 0,
                'confirm' => 0,
            ]);

            $monthlyAmountIds = [];
            foreach ($this->monthlyEntryAmounts as $monthlyEntryAmount) {

                $tillAmount = TillAmount::where('till_id', $this->till_id)->where('currency_id', $monthlyEntryAmount['currency_id'])->first();
               

                $amount = MonthlyEntryAmount::updateOrCreate([
                    'id' => $monthlyEntryAmount['id'] ?? 0,
                ],[
                    'monthly_entry_id' => $this->monthlyEntry_id,
                    'amount' => sanitizeNumber($monthlyEntryAmount['amount']),
                    'currency_id' => $monthlyEntryAmount['currency_id'],
                ]);
                $monthlyAmountIds[] = $amount->id;

                if($tillAmount !== null){
 
                    $updatedAmount = sanitizeNumber($tillAmount->amount) - sanitizeNumber($monthlyEntryAmount['amount']);
                    $tillAmount->update([
                        'amount' => $updatedAmount,
                    ]);
                }else{
                    $newtillAmount = new TillAmount();
                    $newtillAmount->till_id = $this->till_id;
                    $newtillAmount->amount =  sanitizeNumber($monthlyEntryAmount['amount']);
                    $newtillAmount->currency_id = $monthlyEntryAmount['currency_id'];
                    
                    $newtillAmount->save(); 
                }

            }
            MonthlyEntryAmount::where('monthly_entry_id', $this->monthlyEntry_id)->whereNotIn('id', $monthlyAmountIds)->delete();


            return to_route('monthlyEntry')->with('success', 'monthlyEntry has been updated successfully!');
        }
        




    public function render()
    {

        return view('livewire.pcash.monthlyEntry-form');
    }
}
