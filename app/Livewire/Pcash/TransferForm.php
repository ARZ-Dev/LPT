<?php

namespace App\Livewire\Pcash;

use App\Models\Currency;
use App\Models\till;
use App\Models\TillAmount;
use App\Models\Transfer;
use App\Models\TransferAmount;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class TransferForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $transfer;

    public $from_till_id;
    public $to_till_id;

    public  $transferAmount=[];
    public $currency_id;
    public $amount;
    public $deletedTransferAmount = [];
    

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('transfer-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();


        if ($id) {
            $this->editing = true;
            $this->transfer = Transfer::findOrFail($id);

            $this->from_till_id = $this->transfer->from_till_id;
            $this->to_till_id = $this->transfer->to_till_id;
            $this->transferAmount = $this->transfer->transferAmount->toArray();
        }

    }

    protected function rules()
    {
        $rules = [
            'from_till_id' => ['required', 'integer'],
            'to_till_id' => ['required', 'integer'],

            'transferAmount' => ['array'],
            'transferAmount.*.transfer_id' => ['nullable'],
            'transferAmount.*.currency_id' => ['required'],
            'transferAmount.*.amount' => ['required'], 
        ];

        return $rules;
    }

    public function addRow()
    {
        $this->transferAmount[] = ['currency_id' => '','amount' => ''];  
    }

    public function removeRow($key)
    {

      
        if($this->editing == true){
        $removedItemId = $this->transferAmount[$key]['id'] ?? null ;
        $this->deletedTransferAmount[] = $removedItemId;
        }

        unset($this->transferAmount[$key]);
        $this->transferAmount = array_values($this->transferAmount);
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

        $this->authorize('transfer-edit');

        $this->validate();

        DB::beginTransaction();
        try {
        
        $transfer=Transfer::create([
            'from_till_id' => $this->from_till_id ,
            'to_till_id' => $this->to_till_id ,
        ]);



        
        $transferId = $transfer->id;
        foreach ($this->transferAmount as $transferAmount) {
            TransferAmount::create([
                'transfer_id' => $transferId,
                'currency_id' => $transferAmount['currency_id'],
                'amount' => $this->sanitizeNumber($transferAmount['amount']),
            ]);


            $fromTill = TillAmount::where('till_id', $this->from_till_id)->where('currency_id',$transferAmount['currency_id'])->first();
            $toTill = TillAmount::where('till_id', $this->to_till_id)->where('currency_id',$transferAmount['currency_id'])->first();

            if ($fromTill->amount < $this->sanitizeNumber($transferAmount['amount'])) {
                throw new Exception("Cannot transfer, transfered amount does not exists");
            }
            
            if ($fromTill->amount > $this->sanitizeNumber( $transferAmount['amount'])) {

                $fromTill->update([
                    'amount' => $fromTill->amount - $this->sanitizeNumber($transferAmount['amount']),
                ]);

                if (!$toTill) {
                    TillAmount::create([
                        'till_id' => $this->to_till_id,
                        'currency_id' => $fromTill->currency_id,
                        'amount' =>  $this->sanitizeNumber($transferAmount['amount']),
                    ]);

                } else {
                    $toTill->update([
                        'amount' => $toTill->amount +  $this->sanitizeNumber($transferAmount['amount']),
                    ]);
                }
                
            }
        }


    session()->flash('success', 'transfer has been created successfully!');

        DB::commit();
    } catch (\Exception $exception) {
        DB::rollBack();

        return $this->dispatch('swal:error', [
            'title' => 'Error!',
            'text'  => $exception->getMessage(),
        ]);
    }

        return redirect()->route('transfer');
    }



    public function update()
    {
        $this->authorize('transfer-edit');

        $this->validate();

        DB::beginTransaction();
        try {
            $transferAmounts = TransferAmount::with('transfer.fromTill', 'transfer.toTill')
            ->whereHas('transfer.fromTill', function ($query) {
                $query->where('id', $this->from_till_id);
            })
            ->whereHas('transfer.toTill', function ($query) {
                $query->where('id', $this->to_till_id);
            })
            ->where('transfer_id', $this->transfer->id)
            ->get();
        
            foreach ($transferAmounts as $transferAmount) {
                $amount = $transferAmount->amount;

                $fromTill = TillAmount::where('till_id', $this->from_till_id)->where('currency_id',$transferAmount['currency_id'])->first();
                $toTill = TillAmount::where('till_id', $this->to_till_id)->where('currency_id',$transferAmount['currency_id'])->first();

                $fromTill->update([
                    'amount' => $fromTill->amount + $amount,
                ]);

                $toTill->update([
                    'amount' => $toTill->amount - $amount,
                ]);
        
            }

            $this->transfer->update([
                'from_till_id' => $this->from_till_id ,
                'to_till_id' => $this->to_till_id ,
            ]);

            foreach ($this->transferAmount as $transferAmount) {
                $data = [
                    'transfer_id' => $this->transfer->id,
                    'currency_id' => $transferAmount['currency_id'],
                    'amount' => $this->sanitizeNumber($transferAmount['amount']),
                ];
            
                if (isset($transferAmount['id'])) {
                    TransferAmount::updateOrCreate(['id' => $transferAmount['id']], $data);
                } else {
                    TransferAmount::create($data);
                }
            
                TransferAmount::whereIn('id',$this->deletedTransferAmount)->delete();

                $fromTill = TillAmount::where('till_id', $this->from_till_id)->where('currency_id',$transferAmount['currency_id'])->first();
                $toTill = TillAmount::where('till_id', $this->to_till_id)->where('currency_id',$transferAmount['currency_id'])->first();

                if ($fromTill->amount < $this->sanitizeNumber($transferAmount['amount'])) {
                    throw new Exception("Cannot transfer, transfered amount does not exists");
                }

                $fromTill->update([
                    'amount' => $fromTill->amount - $this->sanitizeNumber($transferAmount['amount'])   ,
                ]);
            
                if (!$toTill) {
                    TillAmount::create([
                        'till_id' => $this->to_till_id,
                        'currency_id' => $fromTill->currency_id,
                        'amount' => $this->sanitizeNumber($transferAmount['amount']),
                    ]);
                } else {
                    $toTill->update([
                        'amount' => $toTill->amount + $this->sanitizeNumber($transferAmount['amount']),
                    ]);
                }

            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text'  => $exception->getMessage(),
            ]);
        }
            
        

        session()->flash('success', 'transfer has been updated successfully!');

        return redirect()->route('transfer');
    }
    



    public function render()
    {
        $fromTills = Till::where('user_id',auth()->id())->get();
        $toTills = Till::where('user_id', '<>', auth()->id())->get();
        $currencies = Currency::all();


        return view('livewire.pcash.transfer-form',compact('fromTills','toTills','currencies'));
    }
}
