<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filepond extends Component
{
    public $files = [];
    /**
     * Create a new component instance.
     */
    public function __construct($files = [])
    {
        $this->files = $files;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filepond');
    }
}
