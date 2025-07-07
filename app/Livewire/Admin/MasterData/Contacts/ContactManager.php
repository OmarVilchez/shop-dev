<?php

namespace App\Livewire\Admin\MasterData\Contacts;

use Livewire\Component;

class ContactManager extends Component
{
    public function render()
    {
        return view('livewire.admin.master-data.contacts.contact-manager')->layout('components.layouts.admin');
    }
}
