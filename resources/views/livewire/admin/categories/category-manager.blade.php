<div>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.catalog.categories.index')">
            {{ __('Categories') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-2">
            <h1 class="text-xl sm:text-2xl font-bold dark:text-white">Categorías</h1>
            <button wire:click="openModal" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto">+ Nueva Categoría</button>
        </div>

        <input type="text" wire:model.live="search" placeholder="Buscar..."
            class="border px-4 py-2 rounded w-full mb-4 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" />

        <div class="overflow-x-auto rounded shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-200">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-zinc-800 dark:text-gray-300">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 cursor-pointer whitespace-nowrap" wire:click="sortBy('id')">ID</th>
                        <th class="px-2 sm:px-4 py-2 cursor-pointer whitespace-nowrap" wire:click="sortBy('name')">Nombre</th>
                        <th class="px-2 sm:px-4 py-2 whitespace-nowrap">Descripción</th>
                        <th class="px-2 sm:px-4 py-2 whitespace-nowrap">Estado</th>
                        <th class="px-2 sm:px-4 py-2 whitespace-nowrap">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="border-t dark:border-zinc-700">
                        <td class="px-2 sm:px-4 py-2">{{ $category->id }}</td>
                        <td class="px-2 sm:px-4 py-2">{{ $category->name }}</td>
                        <td class="px-2 sm:px-4 py-2">{{ Str::limit($category->meta_description, 50) }}</td>
                       {{--  <td class="px-2 sm:px-4 py-2">
                            <span class="px-2 py-1 rounded text-white {{ $category->active ? 'bg-green-600' : 'bg-gray-400 dark:bg-zinc-600' }}">
                                {{ $category->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td> --}}

                        {{-- <td class="px-2 sm:px-4 py-2 ">
                            <button wire:click="toggleActive({{ $category->id }})" class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none
                                                            {{ $category->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-700' }}">
                                <span class="inline-block w-5 h-5 transform bg-white rounded-full shadow transition-transform
                                                                {{ $category->active ? 'translate-x-5' : 'translate-x-1' }}">
                                </span>
                            </button>
                            <span class="ml-2 text-xs {{ $category->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ $category->active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td> --}}

                        <td class="px-2 sm:px-4 py-2">
                            <div class="flex items-center gap-2">
                                <button wire:click="toggleActive({{ $category->id }})" class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none
                                                                {{ $category->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-700' }}">
                                    <span class="inline-block w-5 h-5 transform bg-white rounded-full shadow transition-transform
                                                                {{ $category->active ? 'translate-x-5' : 'translate-x-1' }}">
                                    </span>
                                </button>
                                <span class="text-xs {{ $category->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $category->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>                   </td>


                       {{--  <td class="px-2 sm:px-4 py-2 space-x-2">
                            <button wire:click="openModal({{ $category->id }})"
                                class="text-blue-600 dark:text-blue-400 hover:underline">Editar</button>
                            <button wire:click="delete({{ $category->id }})"
                                class="text-red-600 dark:text-red-400 hover:underline">Eliminar</button>
                        </td> --}}

                        <td class="px-2 sm:px-4 py-2 space-x-2">
                            {{-- <a href="#" target="_blank"
                                class="inline-flex items-center p-1 rounded hover:bg-green-100 dark:hover:bg-green-900" title="Ver en tienda">
                                <flux:icon name="eye" class="w-5 h-5 text-green-600 dark:text-green-400" />
                            </a> --}}

                            @if($category->active)
                                <a href="#" target="_blank"
                                    class="inline-flex items-center p-1 rounded hover:bg-green-100 dark:hover:bg-green-900" title="Ver en tienda">
                                    <flux:icon name="globe-alt" class="w-5 h-5 text-green-600 dark:text-green-400" />
                                </a>
                                @else
                                <span class="inline-flex items-center p-1 rounded opacity-50 cursor-not-allowed bg-gray-100 dark:bg-zinc-800"
                                    title="Solo disponible si la categoría está activa">
                                    <flux:icon name="globe-alt" class="w-5 h-5 text-gray-400 dark:text-gray-600" />
                                </span>
                            @endif

                            <button wire:click="openModal({{ $category->id }})"
                                class="inline-flex items-center p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900" title="Editar">
                                <flux:icon name="pencil" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </button>
                            <button wire:click="delete({{ $category->id }})"
                                class="inline-flex items-center p-1 rounded hover:bg-red-100 dark:hover:bg-red-900" title="Eliminar">
                                <flux:icon name="trash" class="w-5 h-5 text-red-600 dark:text-red-400" />
                            </button>                   </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50">
            <div class="bg-white dark:bg-zinc-900 w-full max-w-xl p-4 sm:p-6 rounded shadow-lg mx-2">
                <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">{{ $category_id ? 'Editar Categoría' : 'Nueva Categoría' }}</h2>

                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Nombre</label>
                        <input type="text" wire:model.defer="name" class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Meta título</label>
                        <input type="text" wire:model.defer="meta_title" class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Meta descripción</label>
                        <textarea wire:model.defer="meta_description"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Keywords</label>
                        <textarea wire:model.defer="keywords" class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Posición</label>
                        <input type="number" wire:model.defer="position" class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                    </div>
                    <div>
                        <label class="flex items-center space-x-2 dark:text-gray-200">
                            <input type="checkbox" wire:model.defer="active">
                            <span>Activo</span>
                        </label>
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Imagen (800x800 mínimo, máx 1MB)</label>
                        <input type="file" wire:model="image_desktop_upload" class="w-full dark:text-white">
                        @if($image_desktop)
                        <img src="{{ Storage::url($image_desktop) }}" class="w-32 mt-2">
                        @endif
                        @error('image_desktop_upload') <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-right">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 bg-gray-300 dark:bg-zinc-700 dark:text-white rounded mr-2">Cancelar</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>



{{-- <div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr class=" ">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $category->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $category->name }}
                </td>
                <td class="px-6 py-4">
                    {{ Str::limit($category->description, 100, '...') }}
                </td>
                <td class="px-6 py-4">
                    {{ $category->created_at }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}
