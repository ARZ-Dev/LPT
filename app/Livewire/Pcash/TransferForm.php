<?php

namespace App\Livewire\Pcash;

use App\Models\till;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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

    public $usd_amount;
    public $lbp_amount;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('transfer-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;

        if ($id) {
            $this->editing = true;
            $this->transfer = Transfer::findOrFail($id);

            $this->from_till_id = $this->transfer->from_till_id;
            $this->to_till_id = $this->transfer->to_till_id;
            $this->usd_amount = $this->transfer->usd_amount;
            $this->lbp_amount = $this->transfer->lbp_amount;

        }

    }

    protected function rules()
    {
        $rules = [
            'from_till_id' => ['required', 'integer'],
            'to_till_id' => ['required', 'integer'],
            'usd_amount' => ['required'],
            'lbp_amount' => ['required'],
        ];

        return $rules;
    }

    public function store()
    {
    $this->authorize('transfer-edit');

    $this->validate();

    Transfer::create([
        'from_till_id' => $this->from_till_id ,
        'to_till_id' => $this->to_till_id ,
        'usd_amount' => $this->sanitizeNumber($this->usd_amount) ,
        'lbp_amount' => $this->sanitizeNumber($this->lbp_amount) ,
    ]);


    session()->flash('success', 'transfer has been created successfully!');

    return redirect()->route('transfer');
}



    public function update()
    {
        $this->authorize('transfer-edit');

        $this->validate();

        $this->transfer->update([
            'from_till_id' => $this->from_till_id ,
            'to_till_id' => $this->to_till_id ,
            'usd_amount' => $this->sanitizeNumber($this->usd_amount) ,
            'lbp_amount' => $this->sanitizeNumber($this->lbp_amount) ,

        ]);

        session()->flash('success', 'transfer has been updated successfully!');

        return redirect()->route('transfer');
    }
    

    private function sanitizeNumber($number)
    {
        // Remove commas
        $number = str_replace(',', '', $number);
        // Remove dot at the end, if it exists
        if (substr($number, -1) === '.') {
            $number = substr($number, 0, -1);
        }

        return $number;
    }

    public function render()
    {
        $fromTills = Till::where('user_id',auth()->id())->get();
        $toTills = Till::where('user_id', '<>', auth()->id())->get();

        return view('livewire.pcash.transfer-form',compact('fromTills','toTills'));
    }
}
