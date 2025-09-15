<div class="sm:px-2 sm:py-6 w-[85vw] sm:w-[90vw] max-w-5xl mx-auto">

    <!-- Título -->
    <h2 class="text-lg sm:text-xl font-semibold mb-4 dark:text-white">
        {{ $collection ? 'Editar Colección' : 'Nueva Colección' }}
    </h2>

    <form wire:submit.prevent="save" class="space-y-8">

        <!-- Info + SEO en desktop -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Grupo Información -->
            <div class="p-4 rounded-xl border dark:border-zinc-700 space-y-5">
                <h3 class="text-base font-semibold text-gray-700 dark:text-gray-200">Información</h3>

                <div>
                    <flux:label for="name">Nombre</flux:label>
                    <flux:input id="name" wire:model.defer="name" />
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="description">Descripción</flux:label>
                    <div wire:ignore>
                        <input id="description" type="hidden" wire:model="description">
                        <trix-editor input="description" class="dark:bg-zinc-800 dark:text-white"></trix-editor>
                    </div>
                    @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="type_collection_id">Tipo de colección</flux:label>
                    <flux:select id="type_collection_id" wire:model.defer="type_collection_id">
                        <option value="">Selecciona un tipo</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </flux:select>
                    @error('type_collection_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="active">Estado</flux:label>
                    <flux:checkbox wire:model.defer="active" id="active" :label="__('Activo')" />
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
                    <flux:textarea id="meta_description" wire:model.defer="meta_description" />
                </div>

                <div>
                    <flux:label for="keywords">Keywords</flux:label>
                    <flux:textarea id="keywords" wire:model.defer="keywords" />
                </div>
            </div>
        </div>

        <!-- Grupo Imágenes -->
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
                    // fuerza que la caja llene la fila
                    'containerClass' => 'h-full',
                    ])
                </div>

                {{-- Columna derecha (ocupa 2 filas): Imagen Mobile --}}
                <div class="lg:row-span-2 min-h-[320px]">
                    <flux:label>Imagen Mobile</flux:label>
                    @include('partials.upload-image', [
                    'model' => 'mobileFile',
                    'current' => $img_mobile,
                    'id' => 'mobileFile',
                    'maxSize' => '1MB',
                    'dimensions' => '800x300px mínimo',
                    // hace que el contenedor y la previsualización estiren al alto disponible
                    'containerClass' => 'h-full',
                    'previewClass' => 'w-full h-full object-cover'
                    ])
                </div>

                {{-- Columna izquierda, Fila 2: Desktop --}}
                <div class="min-h-[160px]">
                    <flux:label>Imagen Desktop</flux:label>
                    @include('partials.upload-image', [
                    'model' => 'desktopFile',
                    'current' => $img_desktop,
                    'id' => 'desktopFile',
                    'containerClass' => 'h-full',
                    ])
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
            <flux:button type="button" color="zinc" wire:click="$emit('cancelUpsert')">
                Cancelar
            </flux:button>
            <flux:button type="submit" variant="primary">
                Guardar
            </flux:button>
        </div>
    </form>
</div>
