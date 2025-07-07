<?php

namespace App\Livewire\Admin\Catalog\Quantities;

use Livewire\Component;

class QuantityManager extends Component
{
    public function render()
    {
        return view('livewire.admin.catalog.quantities.quantity-manager')->layout('components.layouts.admin');
    }
}
