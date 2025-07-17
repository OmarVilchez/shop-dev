<?php

namespace App\Livewire\Admin\MasterData\Clients;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class ClientManager extends Component
{
    use WithPagination;

    public $active = false;
    public $search = '';
    public $sortField = '';
    public $sortDirection = '';
    public $filterActive = '';

    public function toggleActive($id)
    {
        $client = User::findOrFail($id);
        $client->active = !$client->active;
        $client->save();
    }


    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortField = $field;
    }

    public function updatedsearch()
    {
        $this->resetPage();
    }

    public function updatedFilterActive()
    {
        $this->resetPage();
    }

    public function render()
    {
        $ClientQuery = User::query();

        if (!empty($this->search)) {
            $ClientQuery = $ClientQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->filterActive !== '') {
            $ClientQuery = $ClientQuery->where('active', $this->filterActive);
        }


        if (!empty($this->sortField)) {
            $ClientQuery = $ClientQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $clients = $ClientQuery->whereDoesntHave('roles')->paginate(10);

        $roles = Role::all();

        return view('livewire.admin.master-data.clients.client-manager', ['clients' => $clients, 'roles' => $roles ] )->layout('components.layouts.admin');
    }
}
