<?php

namespace App\Livewire\Admin\Panel\Orders;

use Livewire\Component;

class OrderManager extends Component
{
    public function render()
    {
        return view('livewire.admin.panel.orders.order-manager')->layout('components.layouts.admin');
    }
}
