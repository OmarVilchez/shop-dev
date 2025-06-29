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
            <button wire:click="openModal"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto">+ Nueva
                Categoría</button>
        </div>

        <input type="text" wire:model.live="search" placeholder="Buscar..."
            class="border px-4 py-2 rounded w-full mb-4 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" />

        <div class="overflow-x-auto rounded shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-200">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-zinc-800 dark:text-gray-300">
                    <tr>
                        <th class="px-2 sm:px-4 py-2 cursor-pointer whitespace-nowrap" wire:click="sortBy('id')">ID</th>
                        <th class="px-2 sm:px-4 py-2 cursor-pointer whitespace-nowrap" wire:click="sortBy('name')">
                            Nombre</th>
                        <th class="px-2 sm:px-4 py-2 cursor-pointer whitespace-nowrap" wire:click="sortBy('title')">
                            Titulo</th>
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
                        <td class="px-2 sm:px-4 py-2">{{ $category->title }}</td>
                        <td class="px-2 sm:px-4 py-2">{{ Str::limit($category->description, 50) }}</td>
                        <td class="px-2 sm:px-4 py-2">
                            <div class="flex items-center gap-2">
                                <button wire:click="toggleActive({{ $category->id }})"
                                    class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none
                                                                {{ $category->active ? 'bg-green-600' : 'bg-gray-300 dark:bg-zinc-700' }}">
                                    <span
                                        class="inline-block w-5 h-5 transform bg-white rounded-full shadow transition-transform
                                                                {{ $category->active ? 'translate-x-5' : 'translate-x-1' }}">
                                    </span>
                                </button>
                                <span
                                    class="text-xs {{ $category->active ? 'text-green-600' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $category->active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-2 sm:px-4 py-2 space-x-2">
                            @if($category->active)
                            <a href="#" target="_blank"
                                class="inline-flex items-center p-1 rounded hover:bg-green-100 dark:hover:bg-green-900"
                                title="Ver en tienda">
                                <flux:icon name="globe-alt" class="w-5 h-5 text-green-600 dark:text-green-400" />
                            </a>
                            @else
                            <span
                                class="inline-flex items-center p-1 rounded opacity-50 cursor-not-allowed bg-gray-100 dark:bg-zinc-800"
                                title="Solo disponible si la categoría está activa">
                                <flux:icon name="globe-alt" class="w-5 h-5 text-gray-400 dark:text-gray-600" />
                            </span>
                            @endif
                            <button wire:click="openModal({{ $category->id }})"
                                class="inline-flex items-center p-1 rounded hover:bg-blue-100 dark:hover:bg-blue-900"
                                title="Editar">
                                <flux:icon name="pencil" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </button>
                            <button wire:click="delete({{ $category->id }})"
                                class="inline-flex items-center p-1 rounded hover:bg-red-100 dark:hover:bg-red-900"
                                title="Eliminar">
                                <flux:icon name="trash" class="w-5 h-5 text-red-600 dark:text-red-400" />
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <flux:modal wire:model="showModal" class="z-50">
        <div class=" sm:px-2 sm:py-6 w-[85vw] sm:w-[95vw] max-w-lg  mx-auto">
            <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
                {{ $category_id ? 'Editar Categoría' : 'Nueva Categoría' }}
            </h2>

            <div x-data="{ tab: 'info' }">
                <div class="flex border-b mb-4">
                    <button class="px-4 py-2 -mb-px border-b-2"
                        :class="tab === 'info' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
                        @click="tab = 'info'" type="button">Información</button>
                    <button class="px-4 py-2 -mb-px border-b-2"
                        :class="tab === 'seo' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
                        @click="tab = 'seo'" type="button">SEO</button>
                </div>

                <div class="relative min-h-[420px] max-h-[80vh] overflow-y-auto space-y-4 transition-all">
                    <form wire:submit.prevent="save" class="space-y-4">
                        <!-- Panel Información  x-transition -->
                        <div x-show="tab === 'info'" class="flex flex-col gap-y-4 w-[98%] mx-auto">
                            <div>
                                <flux:label for="name">Nombre</flux:label>
                                <flux:input id="name" wire:model.defer="name" />
                                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <flux:label for="title">Titulo</flux:label>
                                <flux:input id="title" wire:model.defer="title" />
                                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <flux:label for="description">Description</flux:label>
                                <flux:textarea id="description" wire:model.defer="description" />
                                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <flux:label>Imagen Desktop</flux:label>
                                <div
                                    class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800">
                                    @if($image_desktop)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($image_desktop) }}"
                                            class="w-40 h-40 object-cover rounded shadow border border-gray-200 dark:border-zinc-700">
                                        <button type="button" wire:click="$set('image_desktop', null)"
                                            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                                            title="Eliminar imagen">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    {{-- <p class="text-xs text-gray-500 mt-2">Imagen actual</p> --}}
                                    @elseif($image_desktop_upload)
                                    <div class="relative group">
                                        <img src="{{ $image_desktop_upload->temporaryUrl() }}"
                                            class="w-40 h-40 object-cover rounded shadow border border-gray-200 dark:border-zinc-700">
                                        <button type="button" wire:click="$set('image_desktop_upload', null)"
                                            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                                            title="Eliminar imagen">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    {{-- <p class="text-xs text-gray-500 mt-2">Previsualización</p> --}}
                                    @else
                                    <label for="image_desktop_upload" class="flex flex-col items-center cursor-pointer">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 48 48">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                </path>
                                            </svg>
                                            <span class="text-sm text-gray-600 dark:text-gray-300">Haz clic para subir
                                                una imagen</span>
                                            <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hasta 1MB</span>
                                            <span class="text-xs text-gray-400">800x800px mínimo</span>
                                        </div>
                                        <input id="image_desktop_upload" type="file" wire:model="image_desktop_upload"
                                            class="hidden" accept="image/*">
                                    </label>
                                    @endif

                                    @error('image_desktop_upload')
                                    <span class="text-red-600 text-xs mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <flux:label for="active">Estado</flux:label>
                                <flux:checkbox wire:model.defer="active" id="active" :label="__('Active')" />
                            </div>
                        </div>

                        <!-- Panel SEO x-transition-->
                        <div x-show="tab === 'seo'" class="flex flex-col gap-y-4 w-[98%] mx-auto" x-cloak>
                            <div>
                                <flux:label for="meta_title">Meta título</flux:label>
                                <flux:input id="meta_title" wire:model.defer="meta_title" />
                            </div>
                            <div>
                                <flux:label for="meta_description">Meta descripción</flux:label>
                                <flux:textarea id="meta_description" wire:model.defer="meta_description" />
                            </div>
                            <div>
                                <flux:label for="keywords">Keywords</flux:label>
                                <flux:textarea id="keywords" wire:model.defer="keywords" />
                            </div>
                        </div>

                        <div class="text-right mt-4">
                            <flux:button type="button" color="zinc" wire:click="$set('showModal', false)" class="mr-2">
                                Cancelar
                            </flux:button>
                            <flux:button type="submit" variant="primary">
                                Guardar
                            </flux:button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </flux:modal>

</div>




{{-- Modal con tabs Alpine.js --}}
{{-- @if($showModal)
<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-10 z-50">
    <div class="bg-white dark:bg-zinc-900 w-full max-w-xl p-4 sm:p-6 rounded shadow-lg mx-2">
        <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
            {{ $category_id ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h2>

        <div x-data="{ tab: 'info' }">
            <div class="flex border-b mb-4">
                <button class="px-4 py-2 -mb-px border-b-2"
                    :class="tab === 'info' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
                    @click="tab = 'info'" type="button">Información</button>
                <button class="px-4 py-2 -mb-px border-b-2"
                    :class="tab === 'seo' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
                    @click="tab = 'seo'" type="button">SEO</button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">

                <div x-show="tab === 'info'">
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Nombre</label>
                        <input type="text" wire:model.defer="name"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Posición</label>
                        <input type="number" wire:model.defer="position"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
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

                        @error('image_desktop_upload')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div x-show="tab === 'seo'" x-cloak>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Meta título</label>
                        <input type="text" wire:model.defer="meta_title"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Meta descripción</label>
                        <textarea wire:model.defer="meta_description"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Keywords</label>
                        <textarea wire:model.defer="keywords"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="px-4 py-2 bg-gray-300 dark:bg-zinc-700 dark:text-white rounded mr-2">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif --}}

{{-- <flux:modal wire:model="showModal" class="z-50">
    <div class="p-4 sm:p-6 w-[95vw] max-w-lg mx-auto ">

        <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
            {{ $category_id ? 'Editar Categoría' : 'Nueva Categoría' }}
        </h2>

        <div x-data="{ tab: 'info' }">
            <div class="flex border-b mb-4">
                <button class="px-4 py-2 -mb-px border-b-2"
                    :class="tab === 'info' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
                    @click="tab = 'info'" type="button">Información</button>
                <button class="px-4 py-2 -mb-px border-b-2"
                    :class="tab === 'seo' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
                    @click="tab = 'seo'" type="button">SEO</button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <!-- Panel Información -->
                <div x-show="tab === 'info'" x-transition>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Nombre</label>
                        <input type="text" wire:model.defer="name"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Posición</label>
                        <input type="number" wire:model.defer="position"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Imagen Desktop</label>
                        <div
                            class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-lg p-4 bg-gray-50 dark:bg-zinc-800">
                            @if($image_desktop)
                            <div class="relative group">
                                <img src="{{ Storage::url($image_desktop) }}"
                                    class="w-40 h-40 object-cover rounded shadow border border-gray-200 dark:border-zinc-700">
                                <button type="button" wire:click="$set('image_desktop', null)"
                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                                    title="Eliminar imagen">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Imagen actual</p>
                            @elseif($image_desktop_upload)
                            <div class="relative group">
                                <img src="{{ $image_desktop_upload->temporaryUrl() }}"
                                    class="w-40 h-40 object-cover rounded shadow border border-gray-200 dark:border-zinc-700">
                                <button type="button" wire:click="$set('image_desktop_upload', null)"
                                    class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                                    title="Eliminar imagen">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Previsualización</p>
                            @else
                            <label for="image_desktop_upload" class="flex flex-col items-center cursor-pointer">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Haz clic para subir una
                                        imagen</span>
                                    <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hasta 1MB</span>
                                    <span class="text-xs text-gray-400">800x800px mínimo</span>
                                </div>
                                <input id="image_desktop_upload" type="file" wire:model="image_desktop_upload"
                                    class="hidden" accept="image/*">
                            </label>
                            @endif

                            @error('image_desktop_upload')
                            <span class="text-red-600 text-xs mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center space-x-2 dark:text-gray-200">
                            <input type="checkbox" wire:model.defer="active">
                            <span>Activo</span>
                        </label>
                    </div>

                </div>

                <!-- Panel SEO -->
                <div x-show="tab === 'seo'" x-cloak x-transition>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Meta título</label>
                        <input type="text" wire:model.defer="meta_title"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Meta descripción</label>
                        <textarea wire:model.defer="meta_description"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
                    </div>
                    <div>
                        <label class="block mb-1 dark:text-gray-200">Keywords</label>
                        <textarea wire:model.defer="keywords"
                            class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="button" wire:click="$set('showModal', false)"
                        class="px-4 py-2 bg-gray-300 dark:bg-zinc-700 dark:text-white rounded mr-2">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</flux:modal> --}}



{{-- @if($showModal)
<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-75 z-50">
    <div class="bg-white dark:bg-zinc-900 w-full max-w-xl p-4 sm:p-6 rounded shadow-lg mx-2">
        <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">{{ $category_id ? 'Editar Categoría' :
            'Nueva Categoría' }}</h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block mb-1 dark:text-gray-200">Nombre</label>
                <input type="text" wire:model.defer="name"
                    class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block mb-1 dark:text-gray-200">Meta título</label>
                <input type="text" wire:model.defer="meta_title"
                    class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
            </div>
            <div>
                <label class="block mb-1 dark:text-gray-200">Meta descripción</label>
                <textarea wire:model.defer="meta_description"
                    class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
            </div>
            <div>
                <label class="block mb-1 dark:text-gray-200">Keywords</label>
                <textarea wire:model.defer="keywords"
                    class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700"></textarea>
            </div>
            <div>
                <label class="block mb-1 dark:text-gray-200">Posición</label>
                <input type="number" wire:model.defer="position"
                    class="w-full border rounded px-3 py-2 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
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

                @error('image_desktop_upload')
                <span class="text-red-600 text-sm">{{ $message }}</span>
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
@endif --}}


<!-- Modal -->
{{-- <flux:modal wire:model="showModalOpen" class=" bg-black">
    <div class="mb-4">
        <h2 class="text-lg font-semibold capitalize text-theme-gray">
            {{ $category_id ? __('Editar Categoria') : __('Nueva Categoria') }}
        </h2>
    </div>

    <div class="mb-4">
        <label for="name" class="form-label-new is-required">{{ __('Nombre de categoría') }}</label>
        <div class="mt-1">
            <input type="text" id="name" wire:model.defer="name" class="form-control">
        </div>
        @error('name') <span class="error">*{{ $message }}</span> @enderror
    </div>

    <div class="mb-4 w-[72%]">
        <label class="form-label-new is-required">{{ __('Imagen Desktop') }}</label>
        @if ($image_desktop)
        <div class="relative mt-2 rounded-md border-2 border-dashed border-gray-300 p-2">
            <img class="w-full" src="{{ Storage::url($image_desktop) }}?v={{ time() }}">
            <button type="button" title="Eliminar imagen" wire:click="$set('image_desktop',null)"
                class="absolute right-0 top-0 rounded-full bg-red-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @elseif ($image_desktop_upload)
        <div class="relative mt-2 rounded-md border-2 border-dashed border-gray-300 px-6 pb-6 pt-5">
            <img class="h-auto w-full" src="{{ $image_desktop_upload->temporaryUrl() }}">
            <button type="button" title="Eliminar imagen" wire:click="$set('image_desktop_upload',null)"
                class="absolute right-0 top-0 rounded-full bg-red-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @else
        <div class="mt-1 flex flex-col justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pb-6 pt-5">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"
                    aria-hidden="true">
                    <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
                <div class="flex justify-center text-sm text-gray-600">


                    <label for="image-desktop-upload"
                        class="relative cursor-pointer rounded-md font-medium text-theme-purple hover:text-purple-500">
                        <span>Subir una imagen</span>
                        <input type="file" id="image-desktop-upload" wire:model.defer="image_desktop_upload">
                    </label>

                </div>
                <p class="text-xs text-gray-500">PNG, JPG, JPEG hasta 1MB</p>
                <p class="text-xs text-gray-500">800x800</p>
            </div>
        </div>
        @endif
        @error('image_desktop_upload') <span class="error">*{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="active" class="form-label-new">{{ __('Estado') }}</label>
        <div class="relative mt-1 flex items-start">
            <div class="flex h-5 items-center">
                <input id="active" type="checkbox" wire:model="active"
                    class="h-4 w-4 rounded border-gray-300 text-theme-purple focus:ring-theme-purple">
            </div>
            <div class="ml-3 text-sm">
                <label for="active" class="font-medium text-gray-700">Activar</label>
            </div>
        </div>
    </div>

    <div class="mb-4 mt-6 border-t pt-4">
        <label for="meta_title" class="form-label-new">{{ __('Meta Titulo') }}</label>
        <div class="mt-1">
            <input type="text" id="meta_title" wire:model.defer="meta_title" class="form-control">
        </div>
        @error('meta_title') <span class="error">*{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="meta_description" class="form-label-new">{{ __('Meta Descripción') }}</label>
        <div class="mt-1">
            <textarea id="meta_description" wire:model="meta_description" rows="5" class="form-control"></textarea>
        </div>
        @error('meta_description') <span class="error">*{{ $message }}</span> @enderror
    </div>

    <div class="mb-4">
        <label for="keywords" class="form-label-new">{{ __('Keywords') }}</label>
        <div class="mt-1">
            <textarea id="keywords" wire:model="keywords" rows="5" class="form-control"></textarea>
        </div>
        @error('keywords') <span class="error">*{{ $message }}</span> @enderror
    </div>

    <p class="text-[12px] text-red-500"><b>*</b> Campos obligatorios</p>

    <div class="mt-6 flex justify-end gap-2">
        <button type="button" class="btn btn-secondary" wire:click="$toggle('showModalOpen')"
            wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </button>
        @if ($category_id)
        @can('editar categorias')
        <button type="button" class="btn btn-primary" wire:click="update" wire:target="update"
            wire:loading.attr="disabled">
            {{ __('Actualizar') }}
        </button>
        @endcan
        @else
        @can('crear categorias')
        <button type="button" class="btn btn-primary" wire:click="create" wire:target="create"
            wire:loading.attr="disabled">
            {{ __('Guardar') }}
        </button>
        @endcan
        @endif
    </div>
</flux:modal>
--}}
