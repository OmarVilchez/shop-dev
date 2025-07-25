<?php

namespace App\Livewire\Admin\Accounts\Roles;

use App\Helpers\Flash;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManager extends Component
{
    use WithPagination;

    public $role_id;
    public $name;
    public $search;

    public $sortField = '';
    public $sortDirection = '';

    public $roleSelected;
    public $permissionsApply = [];

    public $showModalRoleOpen = false;
    public $showModalAssignRolesOpen = false;

    protected $queryString = ['sortField' => ['except' => ''], 'sortDirection' => ['except' => '']];

    protected $rules = [
        'name' => 'required|unique:roles,name',
    ];

    public function loadModel()
    {
        $data = Role::find($this->role_id);
        $this->name = $data->name;
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create($this->modelData());
        $this->showModalRoleOpen = false;
        $this->reset();

        Flux::modals()->close();
        Flash::success('Rol registrado correctamente');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::find($this->role_id)->update($this->modelData());
        $this->showModalRoleOpen = false;

        Flux::modals()->close();
        Flash::success('Rol actualizado correctamente');
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->showModalRoleOpen = true;
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->role_id = $id;
        $this->showModalRoleOpen = true;
        $this->loadModel();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function syncPermissions()
    {
        if ($this->roleSelected) {

            // Convertimos IDs a nombres
           /*  $permissions = Permission::whereIn('id', $this->permissionsApply)->pluck('name')->toArray();
            $this->roleSelected->syncPermissions($permissions); */

            $this->roleSelected->permissions()->sync($this->permissionsApply);
            $this->showModalRoleOpen = false;
            $this->reset();
            Flash::success('Permisos asignados');
        }

       //return $this->emit('show-alert', 'seleccione rol', 'error');
    }


    public function AssignPermissonShowModal(Role $role)
    {
        $this->resetValidation();
        $this->reset();
        $this->roleSelected = $role->load('permissions');
        $this->permissionsApply = $this->roleSelected->permissions->pluck('id')->toArray();
        $this->showModalAssignRolesOpen = true;
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection  === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function render()
    {
        $rolesQuery = Role::query();

        if (!empty($this->search)) {
            $rolesQuery = $rolesQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->sortField)) {
            $rolesQuery = $rolesQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $roles = $rolesQuery->paginate(10);

        $permissions = Permission::all();

        return view('livewire.admin.accounts.roles.role-manager', ['roles' => $roles, 'permissions' => $permissions])->layout('components.layouts.admin');
    }
}
