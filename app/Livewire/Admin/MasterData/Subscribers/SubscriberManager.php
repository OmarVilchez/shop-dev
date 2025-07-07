<?php

namespace App\Livewire\Admin\MasterData\Subscribers;

use Livewire\Component;

class SubscriberManager extends Component
{
    public function render()
    {
        return view('livewire.admin.master-data.subscribers.subscriber-manager')->layout('components.layouts.admin');
    }
}
