<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use App\Models\Payment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CategoryView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];
    public $categories;

    public function mount()
    {
        $this->authorize('category-list');
        $this->categories = Category::when(!auth()->user()->hasPermissionTo('category-viewAll'), function ($query) {
                $query->where('user_id', auth()->id());
            })->get();
    }

    public function delete($id)
    {
        $this->authorize('category-delete');

        $category = Category::with('subCategory','payment')->findOrFail($id);

        $category->subCategory()->delete();
        $category->payment()->delete();

        $category->delete();

        return to_route('category')->with('success', 'category has been deleted successfully!');
    }


    public function render()
    {
        return view('livewire.pcash.category-view');
    }
}
