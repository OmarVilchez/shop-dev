{{-- resources/views/partials/upload-image.blade.php CODIGO CON SNIPPER DE CARGA SIMPLE --}}
{{-- <div class="relative border-2 border-dashed rounded-xl p-4 bg-gray-50 dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 flex flex-col items-center justify-center space-y-2 {{ $containerClass ?? '' }}">
    <!-- Vista previa si ya existe en BD -->
    @if($current)
        <div class="group w-full h-full flex items-center justify-center">
            <img src="{{ Str::startsWith($current, 'http') ? $current : Storage::url($current) }}"
                class="{{ $previewClass ?? 'w-40 h-40 object-cover' }} rounded-lg shadow" />
            <button type="button" wire:click="$set('{{ $model }}', null)"
                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                title="Eliminar imagen">
                <flux:icon name="x-mark" class="w-4 h-4" />
            </button>
        </div>

    <!-- Vista previa si se está subiendo (después de seleccionar archivo) -->
    @elseif($this->$model)
        <div class="group w-full h-full flex items-center justify-center">
            <img src="{{ $this->$model->temporaryUrl() }}"
                class="{{ $previewClass ?? 'w-40 h-40 object-cover' }} rounded-lg shadow" />
            <button type="button" wire:click="$set('{{ $model }}', null)"
                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                title="Eliminar imagen">
                <flux:icon name="x-mark" class="w-4 h-4" />
            </button>
        </div>

    <!-- Input de carga -->
    @else
        <label for="{{ $id }}" class="flex flex-col items-center cursor-pointer w-full h-full">
            <div class="flex flex-col items-center justify-center text-center w-full h-full">
                <flux:icon name="cloud-arrow-up" class="w-10 h-10 text-gray-400 mb-2" />
                <span class="text-sm text-gray-600 dark:text-gray-300">Haz clic para subir una imagen</span>
                <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hasta {{ $maxSize ?? '2MB' }}</span>
                <span class="text-xs text-gray-400">{{ $dimensions ?? '800x800px mínimo' }}</span>
            </div>
            <input id="{{ $id }}" type="file" wire:model="{{ $model }}" class="hidden" accept="image/*">
        </label>
    @endif

    <!-- 🔹 Spinner de carga -->
    <div wire:loading wire:target="{{ $model }}" class="absolute inset-0 flex items-center justify-center z-10">
        <flux:icon.loading class="w-6 h-6 text-gray-600 dark:text-gray-200" />
    </div>

    @error($model)
        <span class="error text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>

 --}}


<div x-data="{ isUploading: false, progressImage: 0,
              calcPercentage(min, max, val){return (((val-min)/(max-min))*100).toFixed(0)} }"
    x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progressImage = $event.detail.progress"
    class="relative border-2 border-dashed rounded-xl p-4 bg-gray-50 dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 flex flex-col items-center justify-center {{ $containerClass ?? '' }} min-h-[200px]">

    <!-- Vista previa si ya existe en BD -->
    @if($current)
        <div class="group w-full h-full flex items-center justify-center">
            <img src="{{ Str::startsWith($current, 'http') ? $current : Storage::url($current) }}"
                class="{{ $previewClass ?? 'w-40 h-40 object-cover' }} rounded-lg shadow" />
           {{--  <button type="button" wire:click="$set('{{ $model }}', null)"
                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow opacity-80 group-hover:opacity-100"
                title="Eliminar imagen">
                <flux:icon name="x-mark" class="w-4 h-4" />
            </button> --}}

            <button type="button" @if(isset($deleteMethod)) wire:click="{{ $deleteMethod }}" @else
                wire:click="$set('{{ $model }}', null)" @endif
                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
                title="Eliminar imagen">
                <flux:icon name="x-mark" class="w-4 h-4" />
            </button>

        </div>
    <!-- Vista previa si se está subiendo (después de seleccionar archivo) -->
    @elseif($this->$model)
        <div class="group w-full h-full flex items-center justify-center">
            <img src="{{ $this->$model->temporaryUrl() }}"
                class="{{ $previewClass ?? 'w-40 h-40 object-cover' }} rounded-lg shadow" />
           {{--  <button type="button" wire:click="$set('{{ $model }}', null)"
                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow opacity-80 group-hover:opacity-100"
                title="Eliminar imagen">
                <flux:icon name="x-mark" class="w-4 h-4" />
            </button> --}}
            <button type="button"
                @if(isset($deleteMethod))
                    wire:click="{{ $deleteMethod }}"
                @else
                    wire:click="$set('{{ $model }}', null)"
                @endif
                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow opacity-80 group-hover:opacity-100"
                title="Eliminar imagen">
                <flux:icon name="x-mark" class="w-4 h-4" />
            </button>
        </div>
    <!-- Input de carga -->
    @else
        <label for="{{ $id }}" class="flex flex-col items-center cursor-pointer w-full h-full">
            <div class="flex flex-col items-center justify-center text-center w-full h-full">
                <flux:icon name="cloud-arrow-up" class="w-10 h-10 text-gray-400 mb-2" />
                <span class="text-sm text-gray-600 dark:text-gray-300">Haz clic para subir una imagen</span>
                <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hasta {{ $maxSize ?? '2MB' }}</span>
                <span class="text-xs text-gray-400">{{ $dimensions ?? '800x800px mínimo' }}</span>
            </div>
            <input id="{{ $id }}" type="file" wire:model="{{ $model }}" class="hidden" accept="image/*">
        </label>
    @endif

    <!-- Progress centrado -->
    <template x-if="isUploading">
        <div class="absolute inset-0 flex items-center justify-center bg-black/90 rounded-xl">
            <div class="flex flex-col items-center w-3/4">
                <div class="flex h-4 w-full overflow-hidden rounded-radius bg-surface-alt dark:bg-surface-dark-alt"
                    role="progressbar" aria-label="Cargando imagen..." x-bind:aria-valuenow="progressImage"
                    aria-valuemin="0" aria-valuemax="100">
                    <div class="h-full rounded-radius bg-primary p-0.5 text-center text-xs font-semibold leading-none text-on-primary dark:bg-primary-dark dark:text-on-primary-dark"
                        x-bind:style="`width: ${calcPercentage(0, 100, progressImage)}%`">
                        <span x-text="`${calcPercentage(0, 100, progressImage)}%`"></span>
                    </div>
                </div>
                <span class="text-xs text-gray-300 mt-2">Subiendo imagen...</span>
            </div>
        </div>
    </template>

    @error($model)
        <span class="error text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>
