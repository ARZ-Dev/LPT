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
    public $titleTextColor;
    public $description;
    public $descriptionTextColor;
    public $link;
    public $heroSection;

    public function mount($id = 0)
    {
        if ($id) {
            $this->heroSection = HeroSection::findOrFail($id);
            $this->image = $this->heroSection?->image;
            $this->title = $this->heroSection?->title;
            $this->titleTextColor = $this->heroSection?->title_text_color;
            $this->description = $this->heroSection?->description;
            $this->descriptionTextColor = $this->heroSection?->description_text_color;
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
            'title_text_color' => $this->titleTextColor ?? "#FFFFFF",
            'description' => $this->description,
            'description_text_color' => $this->descriptionTextColor ?? "#FFFFFF",
            'link' => $this->link,
            'is_active' => true,
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
