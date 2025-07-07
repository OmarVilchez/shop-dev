<?php

namespace App\Livewire\Admin\Catalog\Collections;

use Livewire\Component;

class CollectionManager extends Component
{
    public function render()
    {
        return view('livewire.admin.catalog.collections.collection-manager')->layout('components.layouts.admin');
    }
}
