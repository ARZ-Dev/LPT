<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CategoryView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['delete'];

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
        $data = [];

        $categories = Category::all();
        $data['categories'] = $categories;

        return view('livewire.pcash.category-view', $data);
    }
}
