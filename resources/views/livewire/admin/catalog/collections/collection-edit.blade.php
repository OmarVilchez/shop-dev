@section('title')
{{ __('Editar Colección') }}
@endsection
<div class="sm:px-2 sm:py-6 w-[85vw] sm:w-[90vw] max-w-5xl mx-auto">

    <!-- Título -->
    <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
        Editar Colección
    </h2>

    <form wire:submit.prevent="update" class="space-y-8">

       <!-- Info + SEO en desktop -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Grupo Información -->
            <div class="p-4 rounded-xl border dark:border-zinc-700 space-y-5">
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Información</h3>

                <div>
                    <flux:label for="name">Nombre</flux:label>
                    <flux:input id="name" wire:model.defer="name" />
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="description">Descripción</flux:label>
                    <div class="col-span-12" wire:ignore>
                        <textarea id="{{ $editorId }}">{!! $description ?? '' !!}</textarea>
                    </div>
                    @error('description')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <flux:label for="type_collection_id">Tipo de colección</flux:label>
                        <flux:select id="type_collection_id" wire:model.defer="type_collection_id">
                            <option value="">Selecciona un tipo</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </flux:select>
                        @error('type_collection_id') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <flux:label for="active">Estado</flux:label>
                        <flux:checkbox wire:model.defer="active" id="active" :label="__('Activo')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <flux:label for="date_from">Fecha inicio</flux:label>
                        <flux:input id="date_from" type="date" wire:model.defer="date_from" />
                    </div>
                    <div>
                        <flux:label for="date_to">Fecha fin</flux:label>
                        <flux:input id="date_to" type="date" wire:model.defer="date_to" />
                    </div>
                </div>
            </div>

            <!-- Grupo SEO -->
            <div class="p-4 rounded-xl border dark:border-zinc-700 space-y-5">
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">SEO</h3>

                <div>
                    <flux:label for="meta_title">Meta título</flux:label>
                    <flux:input id="meta_title" wire:model.defer="meta_title" />
                </div>

                <div>
                    <flux:label for="meta_description">Meta descripción</flux:label>
                    <flux:textarea rows="6" id="meta_description" wire:model.defer="meta_description" />
                </div>

                <div>
                    <flux:label for="keywords">Keywords</flux:label>
                    <flux:textarea rows="8" id="keywords" wire:model.defer="keywords" />
                </div>
            </div>
        </div>


        <!-- Grupo Productos -->
        <div class="p-4 rounded-xl border dark:border-zinc-700 space-y-5">
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Productos</h3>

            <div class="flex items-center gap-3">
                <flux:input type="text" placeholder="Buscar Productos" wire:model.live="searchInCollection"  />
                <flux:button type="button" wire:click="openProductModal">Navegar</flux:button>
                <flux:select wire:model.defer="orderProducts">
                    <option value="bestseller">Clasificar: Más vendido</option>
                    <option value="newest">Clasificar: Más nuevos</option>
                </flux:select>
            </div>

            @if(empty($selectedProducts))
            <div class="text-center py-10 text-gray-500">
                <flux:icon name="tag" class="w-8 h-8 mx-auto mb-2 text-gray-400" />
                <p>No hay productos en esta colección.</p>
            </div>
            @else
            <ul class="divide-y divide-gray-200 dark:divide-zinc-700">
                {{-- @foreach($selectedProducts as $i => $product) --}}
               @forelse($this->filteredSelectedProducts as $i => $product)
                <li class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-6 text-right">{{ $loop->iteration }}.</span>

                        <img src="{{ $product['image_url'] ?? Storage::url('no-image.png') }}" alt="{{ $product['name'] }}"
                        class="h-12 w-12 object-cover">

                        <span>{{ $product['name'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @if($product['active'])
                        <span
                            class="px-2 py-1 text-xs rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                            Activo
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                            Inactivo
                        </span>
                        @endif
                        <flux:button class="cursor-pointer" size="sm" color="zinc" wire:click="removeProduct({{ $product['id'] }})">
                            x
                        </flux:button>
                    </div>
                </li>

                @empty
                    <div class="text-center py-10 text-gray-500">
                        <flux:icon name="tag" class="w-8 h-8 mx-auto mb-2 text-gray-400" />
                        <p>No hay productos con este nombre en la colección.</p>
                    </div>
                @endforelse
            </ul>
            @endif
        </div>



        <!-- Grupo Imágenes -->
        <div class="p-4 rounded-xl border dark:border-zinc-700 space-y-5 ">
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Imágenes</h3>

            <div class="grid grid-cols-1 lg:grid-cols-2  gap-6  pb-6 ">

                {{-- Columna izquierda, Fila 1: Miniatura --}}
                <div class="min-h-[160px]">
                    <flux:label>Miniatura</flux:label>
                    @include('partials.upload-image', [
                    'model' => 'thumbnailFile',
                    'current' => $thumbnail,
                    'id' => 'thumbnailFile',
                    'deleteMethod' => 'removeThumbnail',
                    // fuerza que la caja llene la fila
                    'containerClass' => 'h-full',
                    'previewClass' => 'w-full h-full object-cover'
                    ])
                </div>

                {{-- Columna derecha (ocupa 2 filas): Imagen Mobile --}}
                <div class="lg:row-span-2 min-h-[320px]">
                    <flux:label>Imagen Mobile</flux:label>
                    @include('partials.upload-image', [
                    'model' => 'mobileFile',
                    'current' => $img_mobile,
                    'id' => 'mobileFile',
                    'deleteMethod' => 'removeMobileImage',
                    'maxSize' => '1MB',
                    'dimensions' => '800x300px mínimo',
                    // hace que el contenedor y la previsualización estiren al alto disponible
                    'containerClass' => 'h-full',
                    'previewClass' => 'w-full h-full object-cover'
                    ])
                </div>

                {{-- Columna izquierda, Fila 2: Desktop --}}
                <div class="min-h-[160px]  mt-8">
                    <flux:label>Imagen Desktop</flux:label>
                    @include('partials.upload-image', [
                    'model' => 'desktopFile',
                    'current' => $img_desktop,
                    'id' => 'desktopFile',
                    'deleteMethod' => 'removeDesktopImage',
                    'containerClass' => 'h-full',
                    'previewClass' => 'w-full h-full object-cover'
                    ])
                </div>
            </div>
        </div>

      <!-- Acciones -->

        <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
            <flux:button type="button" color="zinc" wire:click="cancel">
                Cancelar
            </flux:button>
            <flux:button type="submit" variant="primary">
                Actualizar
            </flux:button>
        </div>
    </form>


    <flux:modal wire:model="showProductModal" class="md:w-lg">
        <div class="space-y-6">
            <!-- Título -->
            <flux:heading size="xl">Agregar productos</flux:heading>

            <!-- Componentes -->
            <flux:input type="text" placeholder="Buscar productos en el catálogo..." wire:model.live="searchInModal" class="w-full mb-4" />

         <div class="max-h-80 overflow-y-auto divide-y dark:divide-zinc-700">
            @foreach($availableProducts as $product)
            @php
            // comparación estricta + caster a int
            $isLocked = in_array((int)$product['id'], $lockedProducts, true);
            @endphp

            <label class="flex items-center gap-3 py-2 cursor-pointer" wire:key="modal-item-{{ $product['id'] }}">
                @if($isLocked)
                <input type="checkbox" class="form-checkbox" checked disabled wire:key="chk-locked-{{ $product['id'] }}">
                @else
                <input type="checkbox" class="form-checkbox" value="{{ $product['id'] }}" wire:model="selectedTemp"
                    wire:key="chk-free-{{ $product['id'] }}">
                @endif

                <img src="{{ $product['image_url'] ?? Storage::url('no-image.png') }}" class="w-10 h-10 object-cover rounded">
                <span>{{ $product['name'] }}</span>
            </label>
            @endforeach
        </div>

            <!-- Acciones -->
            <div class="flex space-x-4">
                    <flux:spacer />
                    <flux:button color="zinc" wire:click="$set('showProductModal', false)">Cancelar</flux:button>
                    <flux:button variant="primary" wire:click="addSelectedProducts">Agregar</flux:button>
            </div>
        </div>
    </flux:modal>

    @include('components.flash-messages')
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let editor = new Jodit("#{{ $editorId }}", {
            autofocus: true,
            height: 200,
            toolbar: true,
            toolbarAdaptive: false,
            showToolbar: true,
            buttons: [
                'bold', 'italic', 'underline', '|',
                'ul', 'ol', '|',
                'link', '|',
                'undo', 'redo'
            ],
            style: {
                color: '#000',
                fontSize: '14px',
            },
            uploader: {
                url: "/upload-image",
                format: "json",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                },
                isSuccess: resp => resp && !resp.error,
                getMessage: resp => resp?.msg || "Error al subir la imagen",
                process: resp => ({
                    files: Array.isArray(resp.files) ? resp.files : []
                }),
                defaultHandlerSuccess: function(data) {
                    data.files?.forEach(file => {
                        if (file) this.s.insertImage(file);
                    });
                },
                error: e => console.error("❌ Error en la subida:", e)
            }
        });

        editor.events.on('change', function() {
            clearTimeout(window.joditTimeout);
            window.joditTimeout = setTimeout(() => {
                window.Livewire.dispatch('updateDescription', { value: editor.value });
            }, 500);
        });

        Livewire.on('refreshJodit', content => {
            editor.value = (content !== null && content !== undefined) ? String(content) : '';
        });
    });
</script>








<!-- Grupo Productos -->
{{-- <div class="p-4 rounded-xl border dark:border-zinc-700 space-y-5">
    <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Productos</h3>

    <div class="flex items-center gap-3">
        <flux:input type="text" placeholder="Buscar Productos" wire:model.defer="searchProducts" class="flex-1" />
        <flux:button type="button" wire:click="openProductModal">
            Navegar
        </flux:button>
        <flux:select wire:model.defer="orderProducts">
            <option value="bestseller">Clasificar: Más vendido</option>
            <option value="newest">Clasificar: Más nuevos</option>
        </flux:select>
    </div>

    @if(empty($selectedProducts))
    <div class="text-center py-10 text-gray-500">
        <flux:icon name="tag" class="w-8 h-8 mx-auto mb-2 text-gray-400" />
        <p>No hay productos en esta colección.</p>
        <p class="text-sm">Busque o explore para agregar productos.</p>
    </div>
    @else
    <ul class="divide-y divide-gray-200 dark:divide-zinc-700">
        @foreach($selectedProducts as $product)
        <li class="flex items-center justify-between py-2">
            <div class="flex items-center gap-3">
                <img src="{{ $product['image'] ?? Storage::url('no-image.png') }}"
                    class="w-10 h-10 object-cover rounded">
                <span>{{ $product['name'] }}</span>
            </div>
            <flux:button size="sm" color="red" wire:click="removeProduct({{ $product['id'] }})">
                Quitar
            </flux:button>
        </li>
        @endforeach
    </ul>
    @endif
</div> --}}
