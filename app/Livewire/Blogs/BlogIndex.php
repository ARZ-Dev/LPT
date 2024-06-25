<?php

namespace App\Livewire\Blogs;

use App\Models\Blog;
use Livewire\Attributes\On;
use Livewire\Component;

class BlogIndex extends Component
{
    public $blogs = [];

    public function mount()
    {
        $this->blogs = Blog::orderBy('order')->get();
    }

    #[On('updateOrder')]
    public function updateOrder($slidersOrder)
    {
        foreach ($slidersOrder as $index => $sliderId) {
            $topSlider = Blog::find($sliderId);
            $topSlider->update([
                'order' => $index + 1,
            ]);
        }

        $this->blogs = Blog::orderBy('order')->get();

        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text'  => "Blogs order has been updated successfully!",
        ]);
    }

    #[On('delete')]
    public function delete($id)
    {
        Blog::whereKey($id)->delete();

        return to_route('blogs')->with('success', 'Blog deleted successfully!');
    }

    public function render()
    {
        return view('livewire.blogs.blog-index');
    }
}
