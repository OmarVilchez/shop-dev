<section>
    @section('title')
    {{ __('Gestor de Banners') }}
    @endsection

    <flux:breadcrumbs class="px-6">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.content.banners.index')">
            {{ __('Banners') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Banners</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="admin-action-btn">Nuevo
                Banner</flux:button>
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
                        <th class="admin-th">Nombre de banner</th>
                        <th class="admin-th">Correo Electrónico</th>
                        <th class="admin-th">Rol Asignado</th>
                        <th class="admin-th">Estado</th>
                        <th class="admin-th">Fecha de Registro</th>
                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="admin-tbody">
                    @forelse ( $banners as $key => $banner )
                    <tr class="admin-row">
                        <td class="admin-td">{{ $banner->id }}</td>
                        <td class="admin-td">{{ $banner->title }}</td>
                        <td class="admin-td">{{ $banner->subtitle }}</td>
                        <td class="admin-td">{{ $banner->descripcion }}</td>

                        <td class="admin-td">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 ">
                                {{ $banner->section ?? 'sin ubicación' }}
                            </span>
                        </td>

                        <!-- Estado switch -->
                        <td class="admin-td">
                            <div class="admin-switch-container">
                                <button wire:click="toggleActive({{ $banner->id }})"
                                    class="admin-switch {{ $banner->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                                    <span
                                        class="admin-switch-thumb {{ $banner->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                                <span
                                    class="text-xs font-medium {{ $banner->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $banner->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </td>

                        <td class="admin-td"> {{ $banner->created_at->format('d-m-Y h:i A') }} </td>

                        <!-- Acciones -->
                        <td class="admin-actions">
                            @can('editar banners')
                            <button wire:click="resetPassword({{ $banner->id }})" class="admin-btn admin-btn-reset"
                                title="Resetear contraseña">
                                <flux:icon name="arrow-path" class="admin-icon-reset" />
                            </button>

                            <button wire:click="updateShowModal({{ $banner->id }})" class="admin-btn admin-btn-edit"
                                title="Editar banner">
                                <flux:icon name="pencil" class="admin-icon-edit" />
                            </button>
                            @endcan
                            @can('eliminar banners')
                            <div class="admin-btn admin-btn-delete">
                                <flux:modal.trigger name="confirmDelete-{{ $banner->id }}" title="Eliminar banner">
                                    <flux:icon name="trash" class="admin-icon-delete" />
                                </flux:modal.trigger>
                            </div>
                            <flux:modal name="confirmDelete-{{ $banner->id }}">
                                <div class="space-y-4">
                                    <flux:heading size="lg">¿Eliminar banner?</flux:heading>
                                    <flux:text>
                                        ¿Estás seguro de que deseas eliminar el banner <strong>{{ $banner->name}}</strong>?
                                    </flux:text>
                                    <div class="flex justify-end gap-2">
                                        <flux:modal.close>
                                            <flux:button variant="ghost">Cancelar</flux:button>
                                        </flux:modal.close>
                                        <flux:button variant="danger" wire:click="delete({{ $banner->id }})">
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
                                <span class="admin-result-text">{{ __('No se ha encontrado ningún banner')}}</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $banners->links() }}
        </div>



    </div>
</section>
