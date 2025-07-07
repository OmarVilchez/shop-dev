<?php

namespace App\Livewire\Admin\Content\Sliders;

use Livewire\Component;

class SliderManager extends Component
{
    public function render()
    {
        return view('livewire.admin.content.sliders.slider-manager')->layout('components.layouts.admin');
    }
}
