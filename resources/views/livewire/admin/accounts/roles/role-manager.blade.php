<section>
    @section('title')
        {{ __('Gestor de Roles') }}
    @endsection

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.accounts.roles.index')">
            {{ __('Roles') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>


    <div class="p-0 sm:p-6 space-y-6">

        <!-- Título y botón -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold tracking-tight text-balance text-gray-800 dark:text-white">Roles</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="rounded-xl shadow-sm">Nuevo Rol</flux:button>
        </div>

        <!-- Filtros -->
        <div class="flex flex-col sm:flex-row gap-3">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="w-full sm:max-w-lg" />
        </div>



        <!-- Tabla -->
        <div class="overflow-x-auto rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-zinc-800 text-xs uppercase">
                    <tr class="text-gray-700 dark:text-gray-300">
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('id')">ID</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('name')">Fecha de Registro</th>
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('title')">Usuarios</th>
                        <th class="px-4 py-3">Permisos</th>
                        <th class="px-4 py-3 sr-only">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @foreach($roles as $rol)
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/40 transition">
                        <td class="px-4 py-2">{{ $rol->id }}</td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium">{{ $rol->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap font-medium">{{ $rol->created_at->format('Y-m-d') }}</td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium ">
                            <div class="px-4 py-1 inline-flex items-center text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                <flux:icon name="user-group" class="mr-2 w-5 h-5 " />
                                {{ $rol->users->count() ?? 0 }}
                            </div>
                        </td>

                        <td class="px-4 py-2 whitespace-nowrap font-medium ">
                            <div class="px-4 py-1 inline-flex items-center text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                <flux:icon name="queue-list" class="mr-2 w-5 h-5 " />
                                {{ $rol->permissions->count() ?? 0 }}
                            </div>
                        </td>

                        <!-- Acciones -->
                        <td class="px-4 py-2 flex flex-row items-center gap-2">
                            <button wire:click="updateShowModal({{ $rol->id }})"
                                class="p-1.5 rounded hover:bg-blue-100 dark:hover:bg-blue-900" title="Editar rol">
                                <flux:icon name="pencil" class=" w-5 h-5 text-blue-600  dark:text-blue-400" />
                            </button>
                            <button wire:click="AssignPermissonShowModal({{ $rol->id }})" class="p-1.5 rounded hover:bg-blue-100 dark:hover:bg-blue-900"
                                title="Asignar rol">
                                <flux:icon name="queue-list" class=" w-5 h-5 text-purple-600  dark:text-purple-400" />
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Paginacion -->
        <div>
            {{ $roles->links() }}
        </div>
    </div>



    <!-- Modal -->
    <flux:modal wire:model="showModalRoleOpen" class="z-50">
        <div class="sm:px-2 sm:py-6 w-[85vw] sm:w-[90vw] max-w-md  mx-auto">
            <!-- Título -->
            <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
                {{ $role_id ? 'Editar Rol' : 'Nuevo Rol' }}
            </h2>

            <!-- Componentes -->
            <div>
                <flux:label for="name">Nombre</flux:label>
                <flux:input id="name" wire:model.defer="name" class="mt-2" />
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Acciones -->
            <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                <flux:button type="button" color="zinc" wire:click="$set('showModalRoleOpen', false)">
                    {{ __('Cancelar') }}
                </flux:button>

                @if ($role_id)
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





</section>
