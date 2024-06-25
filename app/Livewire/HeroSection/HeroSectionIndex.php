<?php

namespace App\Livewire\HeroSection;

use App\Models\HeroSection;
use Livewire\Attributes\On;
use Livewire\Component;

class HeroSectionIndex extends Component
{
    public $heroSections = [];

    public function mount()
    {
        $this->heroSections = HeroSection::orderBy('order')->get();
    }

    #[On('updateOrder')]
    public function updateOrder($slidersOrder)
    {
        foreach ($slidersOrder as $index => $sliderId) {
            $topSlider = HeroSection::find($sliderId);
            $topSlider->update([
                'order' => $index + 1,
            ]);
        }

        $this->heroSections = HeroSection::orderBy('order')->get();

        $this->dispatch('swal:success', [
            'title' => 'Success!',
            'text'  => "Hero sections order has been updated successfully!",
        ]);
    }

    #[On('toggleStatus')]
    public function toggleStatus($id)
    {
        $heroSection = HeroSection::find($id);

        $heroSection->update([
            'is_active' => !$heroSection->is_active,
        ]);

        return to_route('hero-sections')->with('success', 'Hero section status updated successfully!');
    }

    #[On('delete')]
    public function delete($id)
    {
        HeroSection::whereKey($id)->delete();

        return to_route('hero-sections')->with('success', 'Hero section deleted successfully!');
    }

    public function render()
    {
        return view('livewire.hero-section.hero-section-index');
    }
}
