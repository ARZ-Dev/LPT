<?php

namespace App\Livewire\HeroSection;

use App\Models\HeroSection;
use App\Models\HomeSection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class HeroSectionForm extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public $image;
    public $title;
    public $description;
    public $link;
    public $heroSection;

    public function mount($id = 0)
    {
        if ($id) {
            $this->heroSection = HeroSection::findOrFail($id);
            $this->image = $this->heroSection?->image;
            $this->title = $this->heroSection?->title;
            $this->description = $this->heroSection?->description;
            $this->link = $this->heroSection?->link;
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
            $data['image'] = ['required', 'max:2048'];
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
            $data['image'] = $this->image->storePublicly(path: 'public/hero_section/images');
        }

        if ($this->heroSection) {
            $this->heroSection->update($data);
        } else {
            $order = HeroSection::max('order');
            $data['order'] = $order + 1;

            HeroSection::create($data);
        }

        return to_route('hero-sections')->with('success', 'Hero section updated successfully!');
    }

    public function render()
    {
        return view('livewire.hero-section.hero-section-form');
    }
}
