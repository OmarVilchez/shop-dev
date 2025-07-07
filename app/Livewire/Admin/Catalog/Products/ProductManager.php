<?php

namespace App\Livewire\Admin\Catalog\Products;

use Livewire\Component;

class ProductManager extends Component
{
    public function render()
    {
        return view('livewire.admin.catalog.products.product-manager')->layout('components.layouts.admin');
    }
}
