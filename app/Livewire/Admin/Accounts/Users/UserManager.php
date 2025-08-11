<?php

namespace App\Livewire\Admin\Accounts\Users;

use App\Helpers\Flash;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;


class UserManager extends Component
{
    use WithPagination;

    public $user_id;
    public $name;
    public $email;
    public $role_id;
    public $active = false;
    public $password;
    public $password_confirmation;

    public $search;

    public $sortField = '';
    public $sortDirection = '';
    public $filterActive = '';

    public $showModalOpen = false;

    protected $listeners = [
        'deleteUserConfirm' => 'delete',
    ];

    protected $queryString = ['sortField' => ['except' => ''], 'sortDirection' => ['except' => '']];

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'role_id' => 'required|integer|exists:roles,id',
        'active' => 'boolean',
    ];


    public function loadModel()
    {
        $data = User::find($this->user_id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->role_id = $data->roles->first()->id ?? '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->active = $data->active;
    }

    public function modelData()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'active' => $this->active ?? 0,
        ];

        if (!$this->user_id) {
            $data['password'] = Hash::make($this->password);
            $data['password_confirmation'] = Hash::make($this->password_confirmation);
        }

        return $data;
    }

    public function create()
    {
        $rules = $this->rules;
        $rules['password'] = ['required', 'string', Password::min(8), 'confirmed'];
        $rules['password_confirmation'] = 'required|same:password';

        $this->validate($rules);

        $user = User::create($this->modelData());

        $user->forceFill([
            'active' => $this->active ?? 0,
        ])->save();

        //Asignación de rol
        $roleName = Role::find($this->role_id)?->name;

        if ($roleName) {
            $user->syncRoles($roleName);
        }

        $this->showModalOpen = false;
        $this->reset();

        Flash::success('Usuario registrado');
    }

    public function update()
    {
        $rules = $this->rules;
        $rules['email'] = 'required|email|unique:users,email,' . $this->user_id;
        $this->validate($rules);

        User::find($this->user_id)->update($this->modelData());

        $user = User::find($this->user_id);
        $user->forceFill([
            'active' => $this->active ?? 0,
        ])->save();

        //Asignación de rol
        /*  $user->syncRoles($this->role_id); */
        $roleName = Role::find($this->role_id)?->name;

        if ($roleName) {
            $user->syncRoles($roleName);
        }

        $this->showModalOpen = false;

        Flash::success('Usuario actualizado');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->forceFill([
            'password' => Hash::make('123456789'),
        ])->save();

        Flash::success('Se restablecion contraseña a "123456789"');
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
        $this->user_id = $id;
        $this->showModalOpen = true;
        $this->loadModel();
    }

    public function delete($idUser)
    {
        $user = User::findOrFail($idUser);
        $user->delete();
        Flux::modals()->close();
        Flash::success('Usuario eliminado');
    }

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection  === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterActive()
    {
        $this->resetPage();
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();
    }

    public function render()
    {
        $usersManagerQuery = User::query();

        if (!empty($this->search)) {
            $usersManagerQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->sortField)) {
            $usersManagerQuery->orderBy($this->sortField, $this->sortDirection);
        }

        if ($this->filterActive !== '') {
            $usersManagerQuery = $usersManagerQuery->where('active', $this->filterActive);
        }

        $users = $usersManagerQuery->whereHas('roles')->paginate(10);

        $roles = Role::all();

        return view('livewire.admin.accounts.users.user-manager', ['users' => $users, 'roles' => $roles] )->layout('components.layouts.admin');
    }
}
