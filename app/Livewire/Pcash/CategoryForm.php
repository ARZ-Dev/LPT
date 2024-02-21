<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\SubCategory;
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

    public $sub_category = []; 
    public $categoty_id;
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

            $this->sub_category = $this->category->subCategory->toArray();
        }

    }

    protected function rules()
    {
        $rules = [
            'category_name' => ['required', 'string'],

            'sub_category' => ['array'],
            'sub_category.*.categoty_id' => ['nullable', 'integer'],
            'sub_category.*.sub_category_name' => ['nullable', 'string'],   
        ];

        return $rules;
    }


    public function addSubCategory()
    {
        $this->sub_category[] = [
            'category_id' => $this->editing ? $this->category->id : $this->categoty_id,
            'sub_category_name' => ''
        ];
    }

    public function removeSubCategory($index)
    {
        unset($this->sub_category[$index]);
        $this->sub_category = array_values($this->sub_category);
    }


    public function store()
    {   
        $this->authorize('category-edit');

        $this->validate();

        $category = Category::create([
            'category_name' => $this->category_name,
        ]);

        $categoryId = $category->id;

        foreach ($this->sub_category as $subCategory) {
            SubCategory::create([
                'category_id' => $categoryId,
                'sub_category_name' => $subCategory['sub_category_name'],
            ]);
        }
        session()->flash('success', 'category has been created successfully!');

        return redirect()->route('category');
    }


    public function update()
    {
        $this->authorize('category-edit');

        $this->validate();

        $this->category->update([
            'category_name' => $this->category_name,
        ]);

        SubCategory::where('category_id', $this->category->id)->delete();
        foreach ($this->sub_category as $subCategory) {
            SubCategory::create([
                    'category_id' => $this->category->id,
                    'sub_category_name' => $subCategory['sub_category_name'],
                ]);
        }

        session()->flash('success', 'Category has been updated successfully!');

        return redirect()->route('category');
    }
    

    public function render()
    {
        return view('livewire.pcash.category-form');
    }
}
