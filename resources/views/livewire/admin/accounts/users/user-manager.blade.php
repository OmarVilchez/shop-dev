<section>
    @section('title')
     {{ __('Gestor de Usuarios') }}
    @endsection

    <flux:breadcrumbs class="p-6">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.accounts.users.index')">
            {{ __('Usuarios') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Usuarios</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="admin-action-btn">Nuevo
                Usuario</flux:button>
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
                        <th class="admin-th">Imagen</th>
                        <th class="admin-th">Nombre de Usuario</th>
                        <th class="admin-th">Correo Electrónico</th>
                        <th class="admin-th">Rol Asignado</th>
                        <th class="admin-th">Estado</th>
                        <th class="admin-th">Fecha de Registro</th>
                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="admin-tbody">
                    @forelse ( $users as $key => $user )
                        <tr class="admin-row">
                            <td class="admin-td">{{ $user->id }}</td>

                            <td class="whitespace-nowrap px-3 py-3 text-xs text-gray-500 md:text-sm">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full border-2 border-theme-purple"
                                        src="https://ui-avatars.com/api/?name={{ $user->name }}&color=9ca3af&background=000000" alt="">
                                </div>
                            </td>

                            <td class="admin-td">{{ $user->name }}</td>
                            <td class="admin-td">{{ $user->email }}</td>

                            <td class="admin-td">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 ">
                                    {{ $user->roles->first()->name ?? 'cliente' }}
                                </span>
                            </td>

                            <!-- Estado switch -->
                            <td class="admin-td">
                                <div class="admin-switch-container">
                                    <button wire:click="toggleActive({{ $user->id }})"
                                        class="admin-switch {{ $user->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                                        <span class="admin-switch-thumb {{ $user->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                    </button>
                                    <span
                                        class="text-xs font-medium {{ $user->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $user->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </td>

                            <td class="admin-td"> {{ $user->created_at->format('d-m-Y h:i A') }} </td>

                            <!-- Acciones -->
                            <td class="admin-actions">
                                @can('editar usuarios')
                                    <button wire:click="resetPassword({{ $user->id }})" class="admin-btn admin-btn-reset" title="Resetear contraseña">
                                        <flux:icon name="arrow-path" class="admin-icon-reset" />
                                    </button>

                                    <button wire:click="updateShowModal({{ $user->id }})" class="admin-btn admin-btn-edit" title="Editar usuario">
                                        <flux:icon name="pencil" class="admin-icon-edit" />
                                    </button>
                                @endcan
                                @can('eliminar usuarios')
                                    <div class="admin-btn admin-btn-delete">
                                        <flux:modal.trigger name="confirmDelete-{{ $user->id }}" title="Eliminar usuario">
                                            <flux:icon name="trash" class="admin-icon-delete" />
                                        </flux:modal.trigger>
                                    </div>
                                    <flux:modal name="confirmDelete-{{ $user->id }}">
                                        <div class="space-y-4">
                                            <flux:heading size="lg">¿Eliminar usuario?</flux:heading>
                                            <flux:text>
                                                ¿Estás seguro de que deseas eliminar el usuario <strong>{{ $user->name}}</strong>?
                                            </flux:text>
                                            <div class="flex justify-end gap-2">
                                                <flux:modal.close>
                                                    <flux:button variant="ghost">Cancelar</flux:button>
                                                </flux:modal.close>
                                                <flux:button variant="danger" wire:click="delete({{ $user->id }})">
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
                                    <span class="admin-result-text">{{ __('No se ha encontrado ningún usuario')}}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal -->
    <flux:modal wire:model="showModalOpen" class="w-full max-w-3xl">
        <div class="space-y-6">
            <!-- Título -->
            <flux:heading size="lg">
                {{ $user_id ? __('Editar Usuario') : __('Nuevo Usuario') }}
            </flux:heading>

            <!-- Contenido -->
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-6">
                    <flux:input id="name" label="Nombres" wire:model.defer="name" />
                </div>
                <div class="col-span-12 md:col-span-6">
                    <flux:input id="email" label="Correo Electrónico" wire:model.defer="email" type="email" />
                </div>
                <div class="col-span-12 md:col-span-6">
                    <flux:select id="role_id" label="Rol" wire:model.defer="role_id">
                        <option value="">Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
                @if (!$user_id)
                    <div class="col-span-12 md:col-span-6">
                        <flux:input id="password" label="Contraseña" wire:model.defer="password" type="password" />
                    </div>

                    <div class="col-span-12 md:col-span-6">
                        <flux:input id="password_confirmation" label="Confirmación de contraseña" wire:model.defer="password_confirmation" type="password" />
                    </div>
                @endif
                <div class="col-span-12 md:col-span-6">
                    <flux:select id="active" label="Estado" wire:model.defer="active">
                        <option value="0">No Activo</option>
                        <option value="1">Activo</option>
                    </flux:select>
                </div>
            </div>

            <!-- Footer / Acciones -->
            <div class="flex justify-end space-x-4">
                <flux:button color="zinc" wire:click="$set('showModalOpen', false)">
                    {{ __('Cancelar') }}
                </flux:button>

                @if ($user_id)
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

    @include('components.flash-messages')

</section>
