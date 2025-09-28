@section('title')
{{ __('Crear Colección') }}
@endsection
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
                Guardar
            </flux:button>
        </div>
    </form>

    @include('components.flash-messages')

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let editor = new Jodit("#{{ $editorId }}", {
            autofocus: true,
            height: 200,
            //este codigo es para poner opciones basicas
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
            //hasta aqui va la linea
            uploader: {
                url: "/upload-image",
                format: "json",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
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

        // Sincronizar los cambios con Livewire
        editor.events.on('change', function() {
            clearTimeout(window.joditTimeout);
            window.joditTimeout = setTimeout(() => {
               window.Livewire.dispatch('updateDescription', { value: editor.value });
            }, 500);
        });

        // Escuchar evento de Livewire para actualizar Jodit cuando se monte el componente o se guarde
        Livewire.on('refreshJodit', content => {
        editor.value = (content !== null && content !== undefined) ? String(content) : '';
        });

    });
</script>
