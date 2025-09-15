<section>
    @section('title')
    {{ __('Gestor de Colecciones') }}
    @endsection

    <flux:breadcrumbs class="breadcrumbs-admin">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.catalog.collections.index')">
            {{ __('Colecciones') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Colecciones</h1>
           {{--  <flux:button wire:click="openModal" variant="primary" color="green" class="admin-action-btn">Nueva Colección
            </flux:button> --}}

            @can('crear colecciones')
            <a href="{{ route('manager.catalog.collections.create') }}"
                class="inline-flex justify-center rounded-md border border-transparent bg-theme-cyanblue px-4 py-2 text-xs font-semibold uppercase leading-normal text-theme-white opacity-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-transparent focus:ring-offset-2 disabled:opacity-50 hover:opacity-80 max-sm:w-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="mr-1 h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                </svg>
                {{ __('Nuevo colección') }}
            </a>
            @endcan

        </div>

        <!-- Filtros -->
        <div class="admin-filters">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="admin-filter-input" />
            <flux:select wire:model.live="filterType" class="admin-filter-select">
                    <option value="">Tipos de Colecciones</option>
                @foreach ($typeCollections as $typeCollection)
                    <option value="{{ $typeCollection->id }}">{{ ucwords($typeCollection->name) }}
                    </option>
                @endforeach
            </flux:select>
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
                        <th class="admin-th cursor-pointer" wire:click="sortBy('id')">ID</th>
                        <th class="admin-th text-center">Imagen Desktop</th>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('name')">Nombre de Colección</th>
                        <th class="admin-th text-center">Tipos de Colección</th>
                       {{--  <th class="admin-th">Descripción</th> --}}
                        <th class="admin-th text-center">Desde</th>
                        <th class="admin-th">Hasta</th>
                        <th class="admin-th">Estado</th>

                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="admin-tbody">
                    @forelse ( $collections as $key => $collection )
                        <tr class="admin-row">
                            <td class="admin-td">{{ $collection->id }}</td>

                            <!-- Imagen -->
                           <td class="whitespace-nowrap mx-3 ">
                                <div class="w-16 mx-auto  flex-shrink-0">
                                    @if ($collection->image_desktop)
                                    <img src="{{ Storage::url($collection->image_desktop) }} " alt="{{ $collection->name }}" class=" object-cover">
                                    @else
                                    <img src="{{ Storage::url('no-image.png') }} " alt="{{ 'no-image' }}" class="w-20 mx-auto object-cover">
                                    @endif
                                </div>
                            </td>

                            <td class="admin-td">{{ $collection->name }}</td>

                            <!-- Tipo de Coleccion -->
                            <td class="admin-td max-w-[180px] justify-center text-center">
                                <span class="px-2 py-1 text-xs font-medium text-center rounded-full bg-purple-100 text-purple-800">
                                    {{ $collection->typeCollection->name }}
                                </span>
                            </td>

                           {{--  <td class="admin-td max-w-[200px]">{{ Str::limit($collection->description, 30) }}</td> --}}

                            <td class="admin-td text-center">{{ $collection->date_from ?? '-' }}</td>

                            <td class="admin-td">{{ $collection->date_to ?? 'Ilimitado' }}</td>

                            <!-- Estado switch -->
                            <td class="admin-td">
                                <div class="admin-switch-container">
                                    <button wire:click="toggleActive({{ $collection->id }})" class="admin-switch {{ $collection->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-600' }}">
                                        <span class="admin-switch-thumb {{ $collection->active ? 'translate-x-5' : 'translate-x-1' }}"></span>
                                    </button>
                                    <span class="text-xs font-medium {{ $collection->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $collection->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </td>



                            <!-- Acciones -->
                            <td class="admin-td">
                                <div class="admin-actions">
                                    @if($collection->active)
                                        <a href="#" target="_blank" class="admin-btn admin-btn-view" title="Ver en tienda">
                                            <flux:icon name="globe-alt" class="admin-icon-view" />
                                        </a>
                                    @else
                                        <span class="admin-btn admin-btn-disabled" title="Solo si está activa">
                                            <flux:icon name="globe-alt" class="admin-icon-disabled" />
                                        </span>
                                    @endif

                                    @can('editar colecciones')
                                        <button wire:click="openModal({{ $collection->id }})" class="admin-btn admin-btn-edit" title="Editar">
                                            <flux:icon name="pencil" class="admin-icon-edit" />
                                        </button>
                                    @endcan

                                    @can('eliminar colecciones')
                                        <div class="admin-btn admin-btn-delete">
                                            <flux:modal.trigger name="confirmDelete-{{ $collection->id }}">
                                                <flux:icon name="trash" class="admin-icon-delete" />
                                            </flux:modal.trigger>
                                        </div>
                                        <flux:modal name="confirmDelete-{{ $collection->id }}">
                                            <div class="space-y-4">
                                                <flux:heading size="lg">¿Eliminar colección?</flux:heading>
                                                <flux:text>
                                                    ¿Estás seguro de que deseas eliminar la colección <strong>{{ $collection->name }}</strong>?
                                                </flux:text>
                                                <div class="flex justify-end gap-2">
                                                    <flux:modal.close>
                                                        <flux:button variant="ghost">Cancelar</flux:button>
                                                    </flux:modal.close>
                                                    <flux:button variant="danger" wire:click="delete({{ $collection->id }})">
                                                        Eliminar
                                                    </flux:button>
                                                </div>
                                            </div>
                                        </flux:modal>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="admin-result-null">
                                    <span class="admin-result-text">{{ __('No se ha encontrado ninguna colección')}}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $collections->links() }}
        </div>
    </div>







    </div>





</section>




{{-- <div>
        <div class="bg-white text-black shadow overflow-hidden sm:rounded-md">
            <ul wire:sortable="updateTaskOrder" wire:sortable.options='{ "animation": 150 }' class="divide-y">
                @forelse($tasks as $task)
                <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}" class="flex items-center">
                    <div wire:sortable.handle class="cursor-move px-4 py-3">
                        ⠿
                    </div>

                    <div class="flex-1 px-2 py-3">
                        {{ $task->name }}
                    </div>
                </li>
                @empty
                <li class="py-4 text-center text-gray-500">No hay elementos</li>
                @endforelse
            </ul>
        </div>
    </div>
    --}}

{{--
    <div>
        <div class="admin-table-container overflow-hidden">
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
                <tbody wire:sortable="updateTaskOrder" wire:sortable.options='{ "animation": 150 }'
                    class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @forelse($tasks as $task)
                    <tr wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}">
                        <!-- Columna para el handle -->
                        <td wire:sortable.handle class="cursor-move px-4 py-3 text-gray-500">
                            ⠿
                        </td>

                        <!-- Columna con el nombre -->
                        <td class="px-4 py-3">
                            {{ $task->name }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-4 text-center text-gray-500">
                            No hay elementos
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> --}}
