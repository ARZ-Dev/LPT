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

    public $deletedSubCategory = [];

    protected $listeners = ['store', 'update'];

    public function mount($id = 0, $status = 0)
    {
        $this->authorize('category-list');

        $this->roles = Role::pluck('name', 'id');
        $this->status=$status;
        $this->addRow();

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


    public function addRow()
    {
        $this->sub_category[] = [
            'sub_category_name' => ''
        ];
    }

    public function removeSubCategory($index)
    {
        $removedItemId = $this->sub_category[$index]['id'];

            unset($this->sub_category[$index]);
            $this->sub_category = array_values($this->sub_category);
            $this->deletedSubCategory[] = $removedItemId;
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

        foreach ($this->sub_category as $subCategory) {
            $data = [
                'category_id' => $this->category->id,
                'sub_category_name' => $subCategory['sub_category_name'],
            ];
        
            if (isset($subCategory['id'])) {
                SubCategory::updateOrCreate(['id' => $subCategory['id']], $data);
            } else {
                SubCategory::create($data);
            }
        }
        SubCategory::whereIn('id',$this->deletedSubCategory)->delete();
    

        
        session()->flash('success', 'Category has been updated successfully!');

        return redirect()->route('category');
    }

    private function sanitizeNumber($number)
    {
        $number = str_replace(',', '', $number);
        if (substr($number, -1) === '.') {
            $number = substr($number, 0, -1);
        }

        return $number;
    }
    

    public function render()
    {
        return view('livewire.pcash.category-form');
    }
}
