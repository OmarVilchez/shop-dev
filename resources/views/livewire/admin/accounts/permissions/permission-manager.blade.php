<section>

    @section('title')
    {{ 'Gestor de Permisos'}}
    @endsection

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.accounts.permissions.index')">
            {{ __('Permisos') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="p-0 sm:p-6 space-y-6">

        <!-- Título y botón -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold tracking-tight text-balance text-gray-800 dark:text-white">Permisos</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="rounded-xl shadow-sm">Nuevo
                Permiso</flux:button>
        </div>

        <!-- Filtros -->
        <div class="flex flex-col sm:flex-row gap-3">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="w-full" />
        </div>

        <!-- Tabla -->
        <div
            class="overflow-x-auto rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-zinc-800 text-xs uppercase">
                    <tr class="text-gray-700 dark:text-gray-300">
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th class="px-4 py-3">Nombre del Permiso</th>
                        <th class="px-4 py-3">Fecha de Registro</th>
                        <th class="px-4 py-3">Roles</th>
                        <th class="px-4 py-3 sr-only">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse ( $permissions as $key => $permission )
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/40 transition">
                        <td class="px-4 py-2">{{ $permission->id }}</td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium">{{ $permission->name }}</td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium">
                            {{ $permission->created_at->format('d-m-Y') }}
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium ">
                            <div
                                class="px-4 py-1 inline-flex items-center text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                <flux:icon name="user-group" class="mr-2 w-5 h-5 " />
                                {{ $permission->roles->count() ?? 0 }}
                            </div>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium">
                            @can('editar permisos')
                            <button wire:click="updateShowModal({{ $permission->id }})"
                                class="p-1.5 rounded hover:bg-blue-100 dark:hover:bg-blue-900" title="Editar permiso">
                                <flux:icon name="pencil" class=" w-5 h-5 text-blue-600  dark:text-blue-400" />
                            </button>
                            @endcan

                            @can('eliminar permisos')
                            <button wire:click="delete({{ $permission->id }})"
                                class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900" title="Eliminar permiso">
                                <flux:icon name="trash" class="w-5 h-5 text-red-600 dark:text-red-400" />
                            </button>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="flex items-center justify-center">
                                <span class="py-3 text-sm font-medium text-theme-gray">{{ __('No se ha encontrado ningún
                                    permiso')}}</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginacion -->
        <div>
            {{ $permissions->links() }}
        </div>
    </div>

    <!-- Modal -->
    <flux:modal wire:model="showModalOpen" class="z-50">
        <div class="sm:px-2 sm:py-6 w-[85vw] sm:w-[90vw] max-w-md  mx-auto">
            <!-- Título -->
            <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
                {{ $permission_id ? 'Editar Permiso' : 'Nuevo Permiso' }}
            </h2>

            <!-- Componentes -->
            <div>
                <flux:label for="name">Nombre</flux:label>
                <flux:input id="name" wire:model.defer="name" class="mt-2" />
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                <flux:button type="button" color="zinc" wire:click="$set('showModalOpen', false)">
                    {{ __('Cancelar') }}
                </flux:button>

                @if ($permission_id)
                    <flux:button wire:click="update" wire:target="update" wire:loading.attr="disabled" variant="primary">
                        {{ __('Actualizar') }}
                    </flux:button>
                @else
                    <flux:button wire:click="create" wire:target="create" wire:loading.attr="disabled" variant="primary">
                        {{ __('Guardar') }}
                    </flux:button>
                @endif
            </div>
        </div>
    </flux:modal>
    @include('components.flash-messages')
</section>
