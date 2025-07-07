<?php

namespace App\Livewire\Admin\Panel;

use Livewire\Attributes\Layout;
use Livewire\Component;


class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.panel.dashboard')->layout('components.layouts.admin');
    }
}
