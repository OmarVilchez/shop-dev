<?php

namespace App\Livewire\Admin\Catalog\Specifications;

use Livewire\Component;

class SpecificationManager extends Component
{
    public function render()
    {
        return view('livewire.admin.catalog.specifications.specification-manager')->layout('components.layouts.admin');
    }
}
