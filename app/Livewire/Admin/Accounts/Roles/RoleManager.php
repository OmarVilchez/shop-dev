<?php

namespace App\Livewire\Admin\Accounts\Roles;

use Livewire\Component;

class RoleManager extends Component
{
    public function render()
    {
        return view('livewire.admin.accounts.roles.role-manager')->layout('components.layouts.admin');
    }
}
