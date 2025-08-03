<section>
    @section('title')
        {{ __('Gestor de Roles') }}
    @endsection

    <flux:breadcrumbs class="p-6">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.accounts.roles.index')">
            {{ __('Roles') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>


    <div class="admin-section">

        <!-- Título y botón -->
       <div class="admin-header">
            <h1 class="admin-title">Roles</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="admin-action-btn">Nuevo Rol</flux:button>
        </div>

        <!-- Filtros -->
       <div class="admin-filters">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="w-full sm:max-w-lg" />
        </div>

        <!-- Tabla -->
        <div class="admin-table-container overflow-x-auto">
            <table class="admin-table">
                <thead class="admin-thead">
                    <tr>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('id')">ID</th>
                        <th class="admin-th">Rol</th>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('name')">Fecha de Registro</th>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('title')">Usuarios</th>
                        <th class="admin-th">Permisos</th>
                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="admin-tbody">
                    @forelse ($roles as $key => $rol)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/40 transition">
                            <td class="admin-td">{{ $rol->id }}</td>
                            <td class="admin-td">{{ $rol->name }}</td>
                            <td class="admin-td">{{ $rol->created_at->format('Y-m-d') }}</td>
                            <td class="admin-td ">
                                <div class="px-4 py-1 inline-flex items-center text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    <flux:icon name="user-group" class="mr-2 w-5 h-5 " />
                                    {{ $rol->users->count() ?? 0 }}
                                </div>
                            </td>
                            <td class="admin-td ">
                                <div class="px-4 py-1 inline-flex items-center text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    <flux:icon name="queue-list" class="mr-2 w-5 h-5 " />
                                    {{ $rol->permissions->count() ?? 0 }}
                                </div>
                            </td>

                            <!-- Acciones -->
                            <td class="admin-actions">
                                <button wire:click="updateShowModal({{ $rol->id }})"
                                    class="admin-btn admin-btn-edit" title="Editar rol">
                                    <flux:icon name="pencil" class="admin-icon-edit" />
                                </button>
                                <button wire:click="AssignPermissonShowModal({{ $rol->id }})" class="admin-btn hover:bg-blue-100 dark:hover:bg-purple-900"
                                    title="Asignar permisos">
                                    <flux:icon name="queue-list" class="w-6 h-6 text-purple-600 dark:text-purple-400" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="admin-result-null">
                                    <span class="admin-result-text">{{ __('No se ha encontrado ningún rol')}}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginacion -->
        <div>
            {{ $roles->links() }}
        </div>
    </div>

    <!-- Modal para Roles -->
    <flux:modal wire:model="showModalRoleOpen" class="md:w-96">
        <div class="space-y-6">
            <!-- Título -->
            <flux:heading size="lg">{{ $role_id ? 'Editar Rol' : 'Nuevo Rol' }}</flux:heading>

            <!-- Componentes -->
            <div>
                <flux:input label="Nombre" id="name" wire:model.defer="name" class="mt-2" />
            </div>

            <!-- Acciones -->
            <div class="flex space-x-4">
                <flux:spacer />
                <flux:button type="button" color="zinc" wire:click="$set('showModalRoleOpen', false)">
                    {{ __('Cancelar') }}
                </flux:button>
                @if ($role_id)
                    <flux:button wire:click="update" wire:target="update" variant="primary">
                        {{ __('Actualizar') }}
                    </flux:button>
                @else
                    <flux:button wire:click="create" wire:target="create" variant="primary">
                        {{ __('Guardar') }}
                    </flux:button>
                @endif
            </div>
        </div>
    </flux:modal>


    <!-- Modal para Permisos -->
    <flux:modal wire:model="showModalAssignRolesOpen" variant="flyout">
        <div class="space-y-6">
            <!-- Título -->
            <flux:heading size="lg">{{ __('Asignar permisos') }}</flux:heading>

            <!-- Componentes -->
            @if ($roleSelected)
                <div class="gap-4">
                    <flux:checkbox.group wire:model.defer="permissionsApply">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse ($permissions as $permission)
                            <flux:checkbox label="{{ __($permission->name) }}" id="permission-{{ $permission->id }}"
                            value="{{ $permission->id }}"/>
                        @empty
                           <p> No se encontraron permisos </p>
                        @endforelse
                        </div>
                    </flux:checkbox.group>
                </div>
            @endif

            <!-- Acciones -->
            <div class="flex space-x-4">
                <flux:spacer />
                <flux:button type="button" color="zinc" wire:click="$set('showModalAssignRolesOpen', false)">
                    {{ __('Cancelar') }}
                </flux:button>

                <flux:button wire:click="syncPermissions" wire:target="syncPermissions" variant="primary">
                    {{ __('Guardar') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>

    @include('components.flash-messages')
</section>
