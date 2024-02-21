<?php

namespace App\Livewire\Pcash;

use App\Models\Till;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
    public $usd_opening;
    public $lbp_opening;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('till-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;

        if ($id) {
            $this->editing = true;
            $this->till = Till::findOrFail($id);

            $this->user_id = $this->till->user_id;
            $this->name = $this->till->name;
            $this->usd_opening = $this->till->usd_opening;
            $this->lbp_opening = $this->till->lbp_opening;

        }

    }

    protected function rules()
    {
        $rules = [
            'user_id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'usd_opening' => ['required'],
            'lbp_opening' => ['required'],
        ];

        return $rules;
    }

    public function store()
    {
    $this->authorize('till-edit');

    $this->validate();

    Till::create([
        'user_id' => $this->user_id ,
        'name' => $this->name ,
        'usd_opening' => $this->sanitizeNumber($this->usd_opening) ,
        'lbp_opening' => $this->sanitizeNumber($this->lbp_opening) ,
    ]);


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
            'usd_opening' => $this->sanitizeNumber($this->usd_opening) ,
            'lbp_opening' => $this->sanitizeNumber($this->lbp_opening) ,

        ]);

        session()->flash('success', 'till has been updated successfully!');

        return redirect()->route('till');
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
        $users = User::all();
        return view('livewire.pcash.till-form',compact('users'));
    }
}
