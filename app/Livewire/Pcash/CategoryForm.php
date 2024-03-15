<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Payment;
use App\Models\SubCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use App\Utils\Constants;

class CategoryForm extends Component
{
    use AuthorizesRequests;

    public $editing = false;
    public int $status;
    public $type;
    public $category;
    public $user_id;
    public $name;
    public $subCategories = [];
    public bool $submitting = false;


    public function mount($id = 0, $status = 0)
    {
        $this->authorize('category-list');

        $this->status=$status;
        $this->addRow();

        if ($id) {
            $this->editing = true;
            $this->category = Category::with('subCategories','user')->findOrFail($id);



            $this->user_id = $this->category->user_id;
            $this->name = $this->category->name;
            $this->type = $this->category->type;

            $this->subCategories = $this->category->subCategories->toArray();
        }

    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:payment,receipt'],
            'subCategories' => ['array'],
            'subCategories.*.name' => ['required', 'string', 'max:255'],
        ];
    }


    public function addRow()
    {
        $this->subCategories[] = [
            'name' => ''
        ];
    }

    public function removeSubCategory($index)
    {
        unset($this->subCategories[$index]);
    }


    public function store()
    {
        $this->authorize('category-create');
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $category = Category::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'type' => $this->type,
        ]);

        $categoryId = $category->id;

        foreach ($this->subCategories as $subCategory) {
            SubCategory::create([
                'category_id' => $categoryId,
                'name' => $subCategory['name'],
            ]);
        }

        return to_route('category')->with('success', 'Category has been created successfully!');
    }

    public function update()
    {
        $this->authorize('category-edit');
        $this->validate();

        if($this->submitting) {
            return;
        }
        $this->submitting = true;

        $this->category->update([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        $subCategoryIds = [];
        foreach ($this->subCategories as $subCategory) {
            $newSubCategory = SubCategory::updateOrCreate([
                'id' => $subCategory['id'] ?? 0,
            ],[
                'category_id' => $this->category->id,
                'name' => $subCategory['name'],
            ]);

            $subCategoryIds[] = $newSubCategory->id;
        }

        SubCategory::where('category_id', $this->category->id)->whereNotIn('id', $subCategoryIds)->delete();

        return to_route('category')->with('success', 'Category has been updated successfully!');
    }

    public function render()
    {


        if ($this->status == Constants::VIEW_STATUS) {
            return view('livewire.pcash.category.category-view');
        }
        return view('livewire.pcash.category.category-form');
    }
    }

