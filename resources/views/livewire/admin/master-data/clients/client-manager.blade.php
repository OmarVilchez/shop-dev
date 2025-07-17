<section>


@section('title')
    {{ __('Gestor de Clientes') }}
    @endsection

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.master.clients.index')">
            {{ __('Clientes') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="p-0 sm:p-6 space-y-6">

        <!-- Título y botón -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h1 class="text-2xl font-bold tracking-tight text-balance text-gray-800 dark:text-white">Clientes</h1>
        </div>

        <!-- Filtros -->
        <div class="flex flex-col sm:flex-row gap-3">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="w-full" />

            <flux:select id="filterActive" wire:model.live="filterActive" class="w-full sm:max-w-xs">
                <option value="">Todos los estados</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </flux:select>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto rounded-xl shadow-sm ring-1 ring-gray-200 dark:ring-zinc-700 bg-white dark:bg-zinc-900">
            <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-zinc-800 text-xs uppercase">
                    <tr class="text-gray-700 dark:text-gray-300">
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th class="px-4 py-3">Imagen</th>
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('name')">Nombre de Usuario</th>
                        <th class="px-4 py-3 cursor-pointer" wire:click="sortBy('title')">Correo Electrónico</th>
                        <th class="px-4 py-3">Rol</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Fecha de Registro</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse ( $clients as $key => $client )
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/40 transition">
                        <td class="px-4 py-2">{{ $client->id }}</td>
                        <td class="whitespace-nowrap px-3 py-3 text-xs text-gray-500 md:text-sm">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full border-2 border-theme-purple"
                                    src="https://ui-avatars.com/api/?name={{ $client->name }}&color=9ca3af&background=000000"
                                    alt="">
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap font-medium">{{ $client->name }}</td>
                        <td class="px-4 py-2 whitespace-nowrap font-medium">{{ $client->email }}</td>
                        <td class="px-4 py-2 whitespace-nowrap font-medium ">
                           <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800"> {{ $client->roles->first()->name ?? 'Cliente' }} </span>
                        </td>
                         <!-- Estado switch -->
                         <td class="px-4 py-2">
                            <div class="flex items-center gap-2">
                                <button wire:click="toggleActive({{ $client->id }})" class="relative inline-flex items-center h-6 w-11 rounded-full transition-colors focus:outline-none
                                            {{ $client->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                                    <span class="inline-block w-5 h-5 transform bg-white rounded-full shadow transition
                                            {{ $client->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                                <span
                                    class="text-xs font-medium {{ $client->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $client->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap font-medium">
                            {{ $client->created_at->format('d-m-Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="flex items-center justify-center">
                                <span class="py-3 text-sm font-medium text-theme-gray">{{ __('No se ha encontrado ningun cliente')}}</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $clients->links()}}
        </div>
    </div>
</section>
