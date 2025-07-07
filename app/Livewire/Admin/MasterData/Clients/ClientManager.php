<?php

namespace App\Livewire\Admin\MasterData\Clients;

use Livewire\Component;

class ClientManager extends Component
{
    public function render()
    {
        return view('livewire.admin.master-data.clients.client-manager')->layout('components.layouts.admin');
    }
}
