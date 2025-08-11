<section>


@section('title')
    {{ __('Gestor de Clientes') }}
    @endsection

    <flux:breadcrumbs class="breadcrumbs-admin">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.master.clients.index')">
            {{ __('Clientes') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Clientes</h1>
        </div>

        <!-- Filtros -->
        <div class="admin-filters">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="admin-filter-input" />
            <flux:select id="filterActive" wire:model.live="filterActive" class="admin-filter-select">
                <option value="">Todos los estados</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </flux:select>
        </div>

        <!-- Tabla -->
        <div class="admin-table-container overflow-x-auto">
            <table class="admin-table">
                <thead class="admin-thead">
                    <tr>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th class="admin-th">Imagen</th>
                        <th class="admin-th cursor-pointer group" wire:click="sortBy('name')">
                            <span class="flex items-center">
                                Nombre de Usuario
                                <flux:icon
                                    name="{{ $sortField === 'name' ? ($sortDirection === 'asc' ? 'arrow-down' : 'arrow-up') : 'arrow-down' }}"
                                    class="h-3 w-3 ml-2 {{ $sortField !== 'name' ? 'invisible group-hover:visible group-focus:visible' : '' }}" />
                            </span>
                        </th>
                        <th class="admin-th cursor-pointer group" wire:click="sortBy('email')">
                            <span class="flex items-center">
                                Correo Electronico
                                <flux:icon
                                    name="{{ $sortField === 'email' ? ($sortDirection === 'asc' ? 'arrow-down' : 'arrow-up') : 'arrow-down' }}"
                                    class="h-3 w-3 ml-2 {{ $sortField !== 'email' ? 'invisible group-hover:visible group-focus:visible' : '' }}" />
                            </span>
                        </th>
                        <th class="admin-th">Rol</th>
                        <th class="admin-th">Estado</th>
                        <th class="admin-th cursor-pointer text-center group" wire:click="sortBy('created_at')">
                            <span class="flex items-center">
                                Fecha de Registro
                                <flux:icon
                                    name="{{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? 'arrow-down' : 'arrow-up') : 'arrow-down' }}"
                                    class="h-3 w-3 ml-2 {{ $sortField !== 'created_at' ? 'invisible group-hover:visible group-focus:visible' : '' }}" />
                            </span>
                        </th>
                    </tr>
                </thead>

               <tbody class="admin-tbody">
                    @forelse ( $clients as $key => $client )
                   <tr class="admin-row">
                        <td class="admin-td">{{ $client->id }}</td>
                        <td class="whitespace-nowrap px-3 py-3 text-xs text-gray-500 md:text-sm">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full border-2 border-theme-purple"
                                    src="https://ui-avatars.com/api/?name={{ $client->name }}&color=9ca3af&background=000000"
                                    alt="">
                            </div>
                        </td>
                        <td class="admin-td">{{ $client->name }}</td>
                        <td class="admin-td">{{ $client->email }}</td>
                        <td class="admin-td ">
                           <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800"> {{ $client->roles->first()->name ?? 'Cliente' }} </span>
                        </td>
                         <!-- Estado switch -->
                         <td class="admin-td">
                            <div class="admin-switch-container">
                               <button wire:click="toggleActive({{ $client->id }})"
                                    class="admin-switch {{ $client->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                                    <span class="admin-switch-thumb {{ $client->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                                <span class="text-xs font-medium {{ $client->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $client->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </td>
                        <td class="admin-td">
                            {{ $client->created_at->format('d-m-Y h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="admin-result-null">
                                <span class="admin-result-text">{{ __('No se ha encontrado ningun cliente')}}</span>
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
