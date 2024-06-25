<?php

namespace App\Livewire\Blogs;

use App\Models\Blog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class BlogForm extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public $image;
    public $title;
    public $description;
    public $link;
    public $blog;

    public function mount($id = 0)
    {
        if ($id) {
            $this->blog = Blog::findOrFail($id);
            $this->image = $this->blog?->image;
            $this->title = $this->blog?->title;
            $this->description = $this->blog?->description;
            $this->link = $this->blog?->link;
        }
    }

    public function rules()
    {
        $data = [
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'link' => ['nullable']
        ];

        if ($this->image && !is_string($this->image)) {
            $data['image'] = ['required', 'file', 'max:2048'];
        } else {
            $data['image'] = ['nullable', 'max:2048'];
        }

        return $data;
    }

    public function store()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
        ];

        if ($this->image && !is_string($this->image)) {
            $data['image'] = $this->image->storePublicly(path: 'public/blogs/images');
        }

        if ($this->blog) {
            $this->blog->update($data);
        } else {
            $order = Blog::max('order');
            $data['order'] = $order + 1;

            Blog::create($data);
        }

        return to_route('blogs')->with('success', 'Blog updated successfully!');
    }

    public function render()
    {
        return view('livewire.blogs.blog-form');
    }
}
