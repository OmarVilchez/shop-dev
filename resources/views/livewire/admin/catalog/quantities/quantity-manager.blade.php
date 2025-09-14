<section>
    @section('title')
    {{ __('Gestor de Cantidades') }}
    @endsection

    <flux:breadcrumbs class="breadcrumbs-admin">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.catalog.quantities.index')">
            {{ __('Cantidades') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Cantidades</h1>
            <flux:button wire:click="createShowModal" variant="primary" color="green" class="admin-action-btn">Nueva Cantidad</flux:button>
        </div>

        <!-- Filtros -->
        <div class="admin-filters">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar por cantidad mínima..." class="w-full sm:max-w-lg" />
        </div>

        <!-- Tabla -->
        <div class="admin-table-container overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="admin-thead">
                    <tr>
                        <th scope="col" class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th scope="col" class="admin-th text-center">CANT. MINIMA</th>
                        <th scope="col" class="admin-th text-center">CANT. MÁXIMA</th>
                        <th scope="col" class="admin-th text-center">DESCRIPCIÓN</th>
                        <th scope="col" class="admin-th text-center">ESTADO</th>
                        <th scope="col" class="admin-th text-center">FECHA DE REGISTRO</th>
                        <th scope="col" class="admin-th text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody wire:sortable="updateQuantityOrder" wire:sortable.options='{ "animation": 150 }'
                    class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse ($quantities as $quantity)
                    <tr wire:sortable.item="{{ $quantity->id }}" wire:key="quantity-{{ $quantity->id }}">
                        <!-- Columna para el handle -->
                        <td wire:sortable.handle class="cursor-move px-4 py-3 text-gray-500">
                            ⠿
                        </td>

                        <!-- Columna con el nombre -->
                        <td class="px-4 py-2 font-medium text-center">{{ $quantity->quanty_min }}</td>
                        <td class="px-4 py-2 font-medium text-center">{{ $quantity->quanty_max }}</td>
                        <td class="px-4 py-2 font-medium text-center">{{ $quantity->description }}</td>

                        <!-- Estado switch -->
                        <td class="admin-td">
                            <div class="admin-switch-container justify-center">
                                <button wire:click="toggleActive({{ $quantity->id }})"
                                    aria-pressed="{{ $quantity->active ? 'true' : 'false' }}"
                                    class="admin-switch transition-all {{ $quantity->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                                    <span
                                        class="admin-switch-thumb {{ $quantity->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                </button>
                                <span
                                    class="text-xs font-medium {{ $quantity->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $quantity->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </td>

                        <!-- Fecha -->
                        <td class="px-4 py-2 font-medium text-center">
                            {{ $quantity->created_at->format('d-m-Y') }}
                        </td>

                        <!-- Acciones -->
                        <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-center text-xs font-medium sm:pr-6 md:text-sm">
                            @can('editar cantidades')
                                <button wire:click="updateShowModal({{ $quantity->id }})"
                                    class="admin-btn admin-btn-edit inline-flex hover:scale-105 transition-all"
                                    title="Editar cantidad">
                                    <flux:icon name="pencil" class="admin-icon-edit" />
                                </button>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="admin-result-null">
                                <span class="admin-result-text">
                                    {{ __('No se ha encontrado ninguna cantidad')}}
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal para Información de Contacto -->
    <flux:modal wire:model="showModalOpen" variant="flyout">
        <div class="space-y-6">

            <!-- Título -->
            <flux:heading size="lg">
                @if ($quantity_id)
                {{ __('Actualizar Cantidades') }}
                @else
                {{ __('Registrar Cantidad') }}
                @endif
            </flux:heading>

            <!-- Componentes -->
            <flux:input label="Cantidad Mínima" id="quanty_min" wire:model.defer="quanty_min" />
            <flux:input label="Cantidad Máxima" id="quanty_max" wire:model.defer="quanty_max" />
            <flux:textarea label="Descripción" id="description" wire:model.defer="description" />

            <flux:select id="active" label="Estado" wire:model.defer="active">
                <option value="0">No Activo</option>
                <option value="1">Activo</option>
            </flux:select>

            <!-- Acciones -->
            <div class="flex space-x-4">
                <flux:spacer />
                <flux:button color="zinc" wire:click="$set('showModalOpen', false)">
                    {{ __('Cancelar') }}
                </flux:button>

                @if ($quantity_id)
                    @can("editar cantidades")
                        <flux:button variant="primary" wire:click="update" wire:target="update">
                            {{ __('Actualizar') }}
                        </flux:button>
                    @endcan
                @else
                    @can("crear cantidades")
                        <flux:button variant="primary" wire:click="create" wire:target="create">
                            {{ __('Guardar') }}
                        </flux:button>
                    @endcan
                @endif
            </div>

        </div>
    </flux:modal>

    @include('components.flash-messages')

</section>



{{-- <flux:label for="active">Estado</flux:label>
    <flux:checkbox wire:model.defer="active" id="active" :label="__('Activo')" /> --}}












{{-- <div class="admin-table-container overflow-x-auto">
    <table class="admin-table">
        <thead class="admin-thead">
            <tr>
                <th scope="col" class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                <th scope="col" class="admin-th text-center">CANT. MINIMA</th>
                <th scope="col" class="admin-th text-center">CANT. MÁXIMA</th>
                <th scope="col" class="admin-th text-center">DESCRIPCIÓN</th>
                <th scope="col" class="admin-th text-center">ESTADO</th>
                <th scope="col" class="admin-th text-center">FECHA DE REGISTRO</th>
                <th scope="col" class="admin-th text-center">ACCIONES</th>
            </tr>
        </thead>

        <tbody class="admin-tbody" wire:sortable="updateQuantityOrder">
            @forelse ($quantities as $quantity)
            <tr wire:sortable.item="{{ $quantity->id }}" wire:key="quantity-{{ $quantity->id }}" class="admin-row">
                <!-- Drag handle -->
                <td wire:sortable.handle aria-label="Arrastrar para reordenar"
                    class="whitespace-nowrap py-2 pl-4 pr-3 text-xs font-medium md:text-sm cursor-move">
                    <svg class="group h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="stroke-gray-300 group-hover:stroke-theme-gray"
                            d="M7.75 6.5C7.55 6.5 7.36 6.42 7.22 6.28C7.08 6.14 7 5.95 7 5.75C7 5.55 7.08 5.36 7.22 5.22C7.36 5.08 7.55 5 7.75 5C7.95 5 8.14 5.08 8.28 5.22C8.42 5.36 8.5 5.55 8.5 5.75C8.5 5.95 8.42 6.14 8.28 6.28C8.14 6.42 7.95 6.5 7.75 6.5ZM7.75 12.5C7.55 12.5 7.36 12.42 7.22 12.28C7.08 12.14 7 11.95 7 11.75C7 11.55 7.08 11.36 7.22 11.22C7.36 11.08 7.55 11 7.75 11C7.95 11 8.14 11.08 8.28 11.22C8.42 11.36 8.5 11.55 8.5 11.75C8.5 11.95 8.42 12.14 8.28 12.28C8.14 12.42 7.95 12.5 7.75 12.5ZM7.75 18.5C7.55 18.5 7.36 18.42 7.22 18.28C7.08 18.14 7 17.95 7 17.75C7 17.55 7.08 17.36 7.22 17.22C7.36 17.08 7.55 17 7.75 17C7.95 17 8.14 17.08 8.28 17.22C8.42 17.36 8.5 17.55 8.5 17.75C8.5 17.95 8.42 18.14 8.28 18.28C8.14 18.42 7.95 18.5 7.75 18.5Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path class="stroke-gray-300 group-hover:stroke-theme-gray"
                            d="M15.75 6.5C15.55 6.5 15.36 6.42 15.22 6.28C15.08 6.14 15 5.95 15 5.75C15 5.55 15.08 5.36 15.22 5.22C15.36 5.08 15.55 5 15.75 5C15.95 5 16.14 5.08 16.28 5.22C16.42 5.36 16.5 5.55 16.5 5.75C16.5 5.95 16.42 6.14 16.28 6.28C16.14 6.42 15.95 6.5 15.75 6.5ZM15.75 12.5C15.55 12.5 15.36 12.42 15.22 12.28C15.08 12.14 15 11.95 15 11.75C15 11.55 15.08 11.36 15.22 11.22C15.36 11.08 15.55 11 15.75 11C15.95 11 16.14 11.08 16.28 11.22C16.42 11.36 16.5 11.55 16.5 11.75C16.5 11.95 16.42 12.14 16.28 12.28C16.14 12.42 15.95 12.5 15.75 12.5ZM15.75 18.5C15.55 18.5 15.36 18.42 15.22 18.28C15.08 18.14 15 17.95 15 17.75C15 17.55 15.08 17.36 15.22 17.22C15.36 17.08 15.55 17 15.75 17C15.95 17 16.14 17.08 16.28 17.22C16.42 17.36 16.5 17.55 16.5 17.75C16.5 17.95 16.42 18.14 16.28 18.28C16.14 18.42 15.95 18.5 15.75 18.5Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </td>

                <!-- Datos -->
                <td class="admin-td text-center">{{ $quantity->quanty_min }}</td>
                <td class="admin-td text-center">{{ $quantity->quanty_max }}</td>
                <td class="admin-td text-center">{{ $quantity->description }}</td>

                <!-- Estado switch -->
                <td class="admin-td">
                    <div class="admin-switch-container justify-center">
                        <button wire:click="toggleActive({{ $quantity->id }})"
                            aria-pressed="{{ $quantity->active ? 'true' : 'false' }}"
                            class="admin-switch transition-all {{ $quantity->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                            <span
                                class="admin-switch-thumb {{ $quantity->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                        </button>
                        <span
                            class="text-xs font-medium {{ $quantity->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $quantity->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </td>

                <!-- Fecha -->
                <td class="admin-td text-center whitespace-nowrap">
                    {{ $quantity->created_at->format('d-m-Y') }}
                </td>

                <!-- Acciones -->
                <td
                    class="relative whitespace-nowrap py-2 pl-3 pr-4 text-center text-xs font-medium sm:pr-6 md:text-sm">
                    @can('editar cantidades')
                    <button wire:click="updateShowModal({{ $quantity->id }})"
                        class="admin-btn admin-btn-edit inline-flex hover:scale-105 transition-all"
                        title="Editar cantidad">
                        <flux:icon name="pencil" class="admin-icon-edit" />
                    </button>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="admin-result-null">
                        <span class="admin-result-text">
                            {{ __('No se ha encontrado ninguna cantidad')}}
                        </span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div> --}}


<!-- Tabla -->
{{-- <div class="admin-table-container overflow-x-auto">
    <table class="admin-table">
        <thead class="admin-thead">
            <tr>
                <th class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                <th class="admin-th text-center">CANT. MINIMA</th>
                <th class="admin-th text-center">CANT. MÁXIMA</th>
                <th class="admin-th text-center">DESCRIPCIÓN</th>
                <th class="admin-th text-center">ESTADO</th>
                <th class="admin-th text-center">FECHA DE REGISTRO</th>
                <th class="admin-th text-center">ACCIONES</th>
            </tr>
        </thead>

        <tbody class="admin-tbody" wire:sortable="updateQuantityOrder">
            @forelse ($quantities as $key => $quantity)
            <tr wire:sortable.item="{{ $quantity->id }}" wire:key="quantity-{{ $quantity->id }}" class="admin-row">

                <td class="whitespace-nowrap py-2 pl-4 pr-3 text-xs font-medium md:text-sm">
                    <svg wire:sortable.handle class="group h-5 w-5 cursor-pointer" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path class="stroke-gray-300 group-hover:stroke-theme-gray"
                            d="M7.75 6.5C7.55109 6.5 7.36032 6.42098 7.21967 6.28033C7.07902 6.13968 7 5.94891 7 5.75C7 5.55109 7.07902 5.36032 7.21967 5.21967C7.36032 5.07902 7.55109 5 7.75 5C7.94891 5 8.13968 5.07902 8.28033 5.21967C8.42098 5.36032 8.5 5.55109 8.5 5.75C8.5 5.94891 8.42098 6.13968 8.28033 6.28033C8.13968 6.42098 7.94891 6.5 7.75 6.5ZM7.75 12.5C7.55109 12.5 7.36032 12.421 7.21967 12.2803C7.07902 12.1397 7 11.9489 7 11.75C7 11.5511 7.07902 11.3603 7.21967 11.2197C7.36032 11.079 7.55109 11 7.75 11C7.94891 11 8.13968 11.079 8.28033 11.2197C8.42098 11.3603 8.5 11.5511 8.5 11.75C8.5 11.9489 8.42098 12.1397 8.28033 12.2803C8.13968 12.421 7.94891 12.5 7.75 12.5ZM7.75 18.5C7.55109 18.5 7.36032 18.421 7.21967 18.2803C7.07902 18.1397 7 17.9489 7 17.75C7 17.5511 7.07902 17.3603 7.21967 17.2197C7.36032 17.079 7.55109 17 7.75 17C7.94891 17 8.13968 17.079 8.28033 17.2197C8.42098 17.3603 8.5 17.5511 8.5 17.75C8.5 17.9489 8.42098 18.1397 8.28033 18.2803C8.13968 18.421 7.94891 18.5 7.75 18.5Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path class="stroke-gray-300 group-hover:stroke-theme-gray"
                            d="M15.75 6.5C15.5511 6.5 15.3603 6.42098 15.2197 6.28033C15.079 6.13968 15 5.94891 15 5.75C15 5.55109 15.079 5.36032 15.2197 5.21967C15.3603 5.07902 15.5511 5 15.75 5C15.9489 5 16.1397 5.07902 16.2803 5.21967C16.421 5.36032 16.5 5.55109 16.5 5.75C16.5 5.94891 16.421 6.13968 16.2803 6.28033C16.1397 6.42098 15.9489 6.5 15.75 6.5ZM15.75 12.5C15.5511 12.5 15.3603 12.421 15.2197 12.2803C15.079 12.1397 15 11.9489 15 11.75C15 11.5511 15.079 11.3603 15.2197 11.2197C15.3603 11.079 15.5511 11 15.75 11C15.9489 11 16.1397 11.079 16.2803 11.2197C16.421 11.3603 16.5 11.5511 16.5 11.75C16.5 11.9489 16.421 12.1397 16.2803 12.2803C16.1397 12.421 15.9489 12.5 15.75 12.5ZM15.75 18.5C15.5511 18.5 15.3603 18.421 15.2197 18.2803C15.079 18.1397 15 17.9489 15 17.75C15 17.5511 15.079 17.3603 15.2197 17.2197C15.3603 17.079 15.5511 17 15.75 17C15.9489 17 16.1397 17.079 16.2803 17.2197C16.421 17.3603 16.5 17.5511 16.5 17.75C16.5 17.9489 16.421 18.1397 16.2803 18.2803C16.1397 18.421 15.9489 18.5 15.75 18.5Z"
                            stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </td>

                <td class="admin-td text-center">{{ $quantity->quanty_min }}</td>
                <td class="admin-td text-center">{{ $quantity->quanty_max }}</td>
                <td class="admin-td text-center">{{ $quantity->description }}</td>

                <!-- Estado switch -->
                <td class="admin-td">
                    <div class="admin-switch-container justify-center ">
                        <button wire:click="toggleActive({{ $quantity->id }})"
                            class="admin-switch {{ $quantity->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                            <span
                                class="admin-switch-thumb {{ $quantity->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                        </button>
                        <span
                            class="text-xs font-medium {{ $quantity->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                            {{ $quantity->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                </td>

                <td class="admin-td text-center"> {{ $quantity->created_at->format('d-m-Y') }} </td>

                <!-- Acciones -->
                <td class="admin-actions">
                    @can('editar usuarios')
                    <button wire:click="updateShowModal({{ $quantity->id }})" class="admin-btn admin-btn-edit"
                        title="Editar usuario">
                        <flux:icon name="pencil" class="admin-icon-edit" />
                    </button>
                    @endcan
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="admin-result-null">
                        <span class="admin-result-text">{{ __('No se ha encontrado ninguna cantidad')}}</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div>
    {{ $quantities->links() }}
</div> --}}



{{-- <div class="mt-4 flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 md:-mx-4 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden rounded shadow ring-1 ring-black ring-opacity-5">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-black">
                        <tr>
                            <th scope="col"
                                class="py-4 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-white">
                                #
                            </th>
                            <th scope="col"
                                class="px-3 py-4 text-left text-xs font-medium uppercase tracking-wide text-white">
                                CANT. MINIMA
                            </th>
                            <th scope="col"
                                class="px-3 py-4 text-left text-xs font-medium uppercase tracking-wide text-white">
                                CANT. MÁXIMA
                            </th>
                            <th scope="col"
                                class="px-3 py-4 text-left text-xs font-medium uppercase tracking-wide text-white">
                                DESCRIPCIÓN
                            </th>
                            <th scope="col"
                                class="px-3 py-4 text-left text-xs font-medium uppercase tracking-wide text-white">
                                <button type="button" wire:click="sortBy('active')"
                                    class="group inline-flex items-center uppercase">
                                    ESTADO
                                    <span
                                        class="{{ $sortField != 'active' ? 'invisible group-hover:visible group-focus:visible' : '' }} ml-2 flex-none rounded text-white">
                                        <i
                                            class="bx {{ $sortField == 'active' && $sortDirection == 'asc' ? 'bx-sort-z-a' : 'hidden' }}"></i>
                                        <i
                                            class="bx {{ $sortField == 'active' && $sortDirection == 'desc' ? 'bx-sort-a-z' : 'hidden' }}"></i>
                                    </span>
                                </button>
                            </th>
                            <th scope="col"
                                class="px-3 py-4 text-left text-xs font-medium uppercase tracking-wide text-white">
                                <button type="button" wire:click="sortBy('created_at')"
                                    class="group inline-flex items-center uppercase">
                                    Fecha de registro
                                    <span
                                        class="{{ $sortField != 'created_at' ? 'invisible group-hover:visible group-focus:visible' : '' }} ml-2 flex-none rounded text-white">
                                        <i
                                            class="bx {{ $sortField == 'created_at' && $sortDirection == 'asc' ? 'bx-sort-z-a' : 'hidden' }}"></i>
                                        <i
                                            class="bx {{ $sortField == 'created_at' && $sortDirection == 'desc' ? 'bx-sort-a-z' : 'hidden' }}"></i>
                                    </span>
                                </button>
                            </th>
                            <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white" wire:sortable="updateQuantityOrder"
                        wire:sortable.options='{ "animation": 150 }'>
                        @forelse ($quantities as $key => $quantity)
                        <tr wire:sortable.item="{{ $quantity->id }}" wire:key="quantity-{{ $quantity->id }}"
                            class="hover:bg-gray-100" wire:loading.class="opacity-50">
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-xs font-medium md:text-sm">
                                <svg wire:sortable.handle class="group h-5 w-5 cursor-pointer" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="stroke-gray-300 group-hover:stroke-theme-gray"
                                        d="M7.75 6.5C7.55109 6.5 7.36032 6.42098 7.21967 6.28033C7.07902 6.13968 7 5.94891 7 5.75C7 5.55109 7.07902 5.36032 7.21967 5.21967C7.36032 5.07902 7.55109 5 7.75 5C7.94891 5 8.13968 5.07902 8.28033 5.21967C8.42098 5.36032 8.5 5.55109 8.5 5.75C8.5 5.94891 8.42098 6.13968 8.28033 6.28033C8.13968 6.42098 7.94891 6.5 7.75 6.5ZM7.75 12.5C7.55109 12.5 7.36032 12.421 7.21967 12.2803C7.07902 12.1397 7 11.9489 7 11.75C7 11.5511 7.07902 11.3603 7.21967 11.2197C7.36032 11.079 7.55109 11 7.75 11C7.94891 11 8.13968 11.079 8.28033 11.2197C8.42098 11.3603 8.5 11.5511 8.5 11.75C8.5 11.9489 8.42098 12.1397 8.28033 12.2803C8.13968 12.421 7.94891 12.5 7.75 12.5ZM7.75 18.5C7.55109 18.5 7.36032 18.421 7.21967 18.2803C7.07902 18.1397 7 17.9489 7 17.75C7 17.5511 7.07902 17.3603 7.21967 17.2197C7.36032 17.079 7.55109 17 7.75 17C7.94891 17 8.13968 17.079 8.28033 17.2197C8.42098 17.3603 8.5 17.5511 8.5 17.75C8.5 17.9489 8.42098 18.1397 8.28033 18.2803C8.13968 18.421 7.94891 18.5 7.75 18.5Z"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path class="stroke-gray-300 group-hover:stroke-theme-gray"
                                        d="M15.75 6.5C15.5511 6.5 15.3603 6.42098 15.2197 6.28033C15.079 6.13968 15 5.94891 15 5.75C15 5.55109 15.079 5.36032 15.2197 5.21967C15.3603 5.07902 15.5511 5 15.75 5C15.9489 5 16.1397 5.07902 16.2803 5.21967C16.421 5.36032 16.5 5.55109 16.5 5.75C16.5 5.94891 16.421 6.13968 16.2803 6.28033C16.1397 6.42098 15.9489 6.5 15.75 6.5ZM15.75 12.5C15.5511 12.5 15.3603 12.421 15.2197 12.2803C15.079 12.1397 15 11.9489 15 11.75C15 11.5511 15.079 11.3603 15.2197 11.2197C15.3603 11.079 15.5511 11 15.75 11C15.9489 11 16.1397 11.079 16.2803 11.2197C16.421 11.3603 16.5 11.5511 16.5 11.75C16.5 11.9489 16.421 12.1397 16.2803 12.2803C16.1397 12.421 15.9489 12.5 15.75 12.5ZM15.75 18.5C15.5511 18.5 15.3603 18.421 15.2197 18.2803C15.079 18.1397 15 17.9489 15 17.75C15 17.5511 15.079 17.3603 15.2197 17.2197C15.3603 17.079 15.5511 17 15.75 17C15.9489 17 16.1397 17.079 16.2803 17.2197C16.421 17.3603 16.5 17.5511 16.5 17.75C16.5 17.9489 16.421 18.1397 16.2803 18.2803C16.1397 18.421 15.9489 18.5 15.75 18.5Z"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-2 text-xs font-medium uppercase text-gray-500 md:text-base">
                                {{ $quantity->quanty_min }}
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-2 text-xs font-medium uppercase text-gray-500 md:text-base">
                                {{ $quantity->quanty_max }}
                            </td>
                            <td
                                class="whitespace-nowrap px-3 py-2 text-xs font-medium uppercase text-gray-500 md:text-sm">
                                {{ $quantity->description }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-2 text-xs text-gray-500 md:text-sm">
                                <label class="inline-flex cursor-pointer items-center">
                                    <input type="checkbox" wire:click="toggleActive({{ $quantity->id }})" {{
                                        $quantity->active ? 'checked' : '' }}
                                    class="peer invisible">
                                    <div
                                        class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-green-400 peer-checked:after:translate-x-full peer-checked:after:border-white rtl:peer-checked:after:-translate-x-full dark:border-gray-600 dark:bg-red-700">
                                    </div>
                                    <span
                                        class="{{ $quantity->active ? 'text-green-900 font-bold' : 'opacity-50' }} text-theme-main ms-3 text-sm font-medium">{{
                                        $quantity->active ? 'Activo' : 'No Activo' }}</span>
                                </label>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2 text-xs font-medium text-gray-500 md:text-base">
                                {{ $quantity->created_at->format('d-m-Y') }}
                            </td>
                            <td
                                class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-xs font-medium sm:pr-6 md:text-sm">
                                @can('editar cantidades')
                                <button type="button" wire:click="updateShowModal({{ $quantity->id }})"
                                    title="Editar cantidad"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-amber-500 p-2 text-sm font-medium uppercase leading-normal text-theme-white shadow-sm hover:bg-amber-500 hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-transparent focus:ring-offset-2 disabled:opacity-50">
                                    <svg class="h-4 w-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                        fill="none">
                                        <path fill="#ffffff" fill-rule="evenodd"
                                            d="M15.747 2.97a.864.864 0 011.177 1.265l-7.904 7.37-1.516.194.653-1.785 7.59-7.044zm2.639-1.366a2.864 2.864 0 00-4-.1L6.62 8.71a1 1 0 00-.26.39l-1.3 3.556a1 1 0 001.067 1.335l3.467-.445a1 1 0 00.555-.26l8.139-7.59a2.864 2.864 0 00.098-4.093zM3.1 3.007c0-.001 0-.003.002-.005A.013.013 0 013.106 3H8a1 1 0 100-2H3.108a2.009 2.009 0 00-2 2.19C1.256 4.814 1.5 7.848 1.5 10c0 2.153-.245 5.187-.391 6.81A2.009 2.009 0 003.108 19H17c1.103 0 2-.892 2-1.999V12a1 1 0 10-2 0v5H3.106l-.003-.002a.012.012 0 01-.002-.005v-.004c.146-1.62.399-4.735.399-6.989 0-2.254-.253-5.37-.4-6.99v-.003zM17 17c-.001 0 0 0 0 0zm0 0z" />
                                    </svg>
                                </button>
                                @endcan
                                @can('eliminar cantidades')
                                <button type="button" wire:click="confirmRemovalQuantity({{ $quantity->id }})"
                                    title="Eliminar cantidad" wire:loading.attr="disabled"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-red-500 p-2 text-sm font-medium uppercase leading-normal text-theme-white shadow-sm hover:bg-theme-red focus:outline-none focus:ring-2 focus:ring-transparent focus:ring-offset-2 disabled:opacity-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="flex items-center justify-center">
                                    <span class="py-2 text-sm font-medium text-theme-gray">{{ __('No se ha encontrado
                                        ninguna categoria') }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}
