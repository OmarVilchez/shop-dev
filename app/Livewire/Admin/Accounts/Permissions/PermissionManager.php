<?php

namespace App\Livewire\Admin\Accounts\Permissions;

use App\Helpers\Flash;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionManager extends Component
{

    use WithPagination;

    public $permission_id;
    public $name;
    public $search;

    public $sortField = '';
    public $sortDirection = '';

    public $showModalOpen = false;

    protected $rules = [
        'name' => 'required|unique:permissions,name',
    ];

    public function create()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create($this->modelData());
        $this->showModalOpen = false;
        $this->reset();

        Flash::success('Permiso guardado exitosamente');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $this->validate();
        Permission::find($this->permission_id)->update($this->modelData());
        $this->showModalOpen = false;

        Flash::success('Permiso actualizado exitosamente');
    }

 /*    public function delete($id)
    {
        $permission = Permission::findOrFail($id);
        if (Auth::user()->can('eliminar permisos')) {
            $this->dispatch('show-alert', title: 'Eliminado', message: 'Permiso eliminado');
        }
    }
 */
    public function loadModel()
    {
        $data = Permission::find($this->permission_id);
        $this->name = $data->name;
    }

    public function modelData()
    {
        return [
            'name' => $this->name,
        ];
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->showModalOpen = true;
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->permission_id = $id;
        $this->showModalOpen = true;
        $this->loadModel();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection  === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    /*  public $confirmingPermissionDeletion = false;
    public $permissionIdToDelete = null;


    public function deletePermission()
    {
        $permission = Permission::findOrFail($this->permissionIdToDelete);

        if (Auth::user()->can('eliminar permisos')) {
            $permission->delete();

            $this->dispatch('show-alert', title: 'Eliminado', message: 'Permiso eliminado exitosamente');
        }

        $this->confirmingPermissionDeletion = false;
        $this->permissionIdToDelete = null;
    }

    public function confirmDelete($id)
    {
        $this->permissionIdToDelete = $id;
        $this->confirmingPermissionDeletion = true;
    } */


    public function eliminar($id)
    {
        Permission::findOrFail($id)->delete();
        Flux::modals()->close();
        Flash::success('Permiso eliminado correctamente');
    }


    public function render()
    {
        $permissionsQuery = Permission::query();

        if (!empty($this->search)) {
            $permissionsQuery = $permissionsQuery->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->sortField)) {
            $permissionsQuery = $permissionsQuery->orderBy($this->sortField, $this->sortDirection);
        }

        $permissions = $permissionsQuery->paginate(20);


        return view('livewire.admin.accounts.permissions.permission-manager', ['permissions' => $permissions])->layout('components.layouts.admin');
    }

}
