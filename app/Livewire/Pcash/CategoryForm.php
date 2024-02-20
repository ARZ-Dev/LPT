<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CategoryForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;

    public $roles;
    public $category;

    public $category_name;
    public $sub_category_name;

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('category-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;

        if ($id) {
            $this->editing = true;
            $this->category = Category::findOrFail($id);

            $this->category_name = $this->category->category_name;
            $this->sub_category_name = $this->category->sub_category_name;
        }

    }

    protected function rules()
    {
        $rules = [
            'category_name' => ['required', 'string'],
            'sub_category_name' => ['required', 'string'],
        ];

        return $rules;
    }

    public function store()
    {
    $this->authorize('category-edit');

    $this->validate();

    Category::create([
        'category_name' => $this->category_name ,
        'sub_category_name' => $this->sub_category_name ,
    ]);


    session()->flash('success', 'category has been created successfully!');

    return redirect()->route('category');
}


    public function update()
    {
        $this->authorize('category-edit');

        $this->validate();

        $this->category->update([
            'category_name' => $this->category_name ,
            'sub_category_name' => $this->sub_category_name ,
        ]);

        session()->flash('success', 'category has been updated successfully!');

        return redirect()->route('category');
    }
    

    public function render()
    {
        return view('livewire.pcash.category-form');
    }
}
