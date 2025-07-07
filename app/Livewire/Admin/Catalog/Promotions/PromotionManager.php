<?php

namespace App\Livewire\Admin\Catalog\Promotions;

use Livewire\Component;

class PromotionManager extends Component
{
    public function render()
    {
        return view('livewire.admin.catalog.promotions.promotion-manager')->layout('components.layouts.admin');
    }
}
