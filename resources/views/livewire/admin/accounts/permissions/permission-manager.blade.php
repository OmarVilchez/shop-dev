<section>
    @section('title')
        {{ __('Gestor de Permisos') }}
    @endsection

    <flux:breadcrumbs class="p-6">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.accounts.permissions.index')">
            {{ __('Permisos') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Permisos</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="admin-action-btn">Nuevo Permiso</flux:button>
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
                        <th class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th class="admin-th">Nombre del Permiso</th>
                        <th class="admin-th">Fecha de Registro</th>
                        <th class="admin-th">Roles</th>
                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="admin-tbody">
                    @forelse ( $permissions as $key => $permission )
                        <tr class="admin-row">
                            <td class="admin-td">{{ $permission->id }}</td>
                            <td class="admin-td">{{ $permission->name }}</td>
                            <td class="admin-td"> {{ $permission->created_at->format('d-m-Y') }} </td>
                            <td class="admin-td">
                                <div class="px-4 py-1 inline-flex items-center text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    <flux:icon name="user-group" class="mr-2 w-5 h-5 " />
                                    {{ $permission->roles->count() ?? 0 }}
                                </div>
                            </td>
                            <!-- Acciones -->
                            <td class="admin-actions">
                                @can('editar permisos')
                                    <button wire:click="updateShowModal({{ $permission->id }})"
                                        class="admin-btn admin-btn-edit" title="Editar permiso">
                                        <flux:icon name="pencil" class="admin-icon-edit" />
                                    </button>
                                @endcan
                                @can('eliminar permisos')
                                    <div class="admin-btn admin-btn-delete">
                                        <flux:modal.trigger name="confirmDelete-{{ $permission->id }}" >
                                        <flux:icon name="trash" class="admin-icon-delete" />
                                        </flux:modal.trigger>
                                    </div>
                                    <flux:modal name="confirmDelete-{{ $permission->id }}">
                                        <div class="space-y-4">
                                            <flux:heading size="lg">¿Eliminar permiso?</flux:heading>
                                            <flux:text>
                                                ¿Estás seguro de que deseas eliminar el permiso <strong>{{ $permission->name }}</strong>?
                                            </flux:text>
                                            <div class="flex justify-end gap-2">
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancelar</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" wire:click="eliminar({{ $permission->id }})">
                                                    Eliminar
                                                </flux:button>
                                            </div>
                                        </div>
                                    </flux:modal>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="admin-result-null">
                                    <span class="admin-result-text">{{ __('No se ha encontrado ningún permiso')}}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $permissions->links() }}
        </div>
    </div>

    <!-- Modal -->
    <flux:modal wire:model="showModalOpen" class="md:w-96">
        <div class="space-y-6">
            <!-- Título -->
            <flux:heading size="lg">{{ $permission_id ? 'Editar Permiso' : 'Nuevo Permiso' }}</flux:heading>

            <!-- Componentes -->
            <div>
                <flux:input label="Nombre" id="name" wire:model.defer="name" class="mt-2" />
            </div>

            <!-- Acciones -->
            <div class="flex space-x-4">
                <flux:spacer />
                <flux:button type="button" color="zinc" wire:click="$set('showModalOpen', false)">{{ __('Cancelar') }}</flux:button>
                @if ($permission_id)
                    <flux:button wire:click="update" wire:target="update" variant="primary">{{ __('Actualizar') }}</flux:button>
                @else
                    <flux:button wire:click="create" wire:target="create"  variant="primary">{{ __('Guardar') }}</flux:button>
                @endif
            </div>
        </div>
    </flux:modal>

    @include('components.flash-messages')
</section>




{{-- <button wire:click="confirmDelete({{ $permission->id }})" class="admin-btn admin-btn-delete">
            <flux:icon name="trash" class="admin-icon-delete" />
        </button> --}}

        {{-- <flux:button color="red" wire:click="eliminar({{ $permission->id }})">
            <flux:icon name="trash" />
        </flux:button> --}}
