<?php

namespace App\Livewire\Pcash;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Livewire\Component;

class CategoryView extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['deleteConfirm','delete'];

    public function deleteConfirm($method, $id = null): void
    {
        $this->dispatch('swal:confirm', [
            'type'  => 'warning',
            'title' => 'Are you sure?',
            'text'  => 'You won\'t be able to revert this!',
            'id'    => $id,
            'method' => $method,
        ]);
    }

    public function delete($id)
    {
        $this->authorize('category-delete');

        $category = Category::findOrFail($id);

        $category->subCategory()->delete();
        $category->delete();

        return to_route('category')->with('success', 'category has been deleted successfully!');
    }


    public function render()
    {
        $data = [];

        $category = Category::all();
        $data['category'] = $category;

        return view('livewire.pcash.category-view', $data);
    }
}
