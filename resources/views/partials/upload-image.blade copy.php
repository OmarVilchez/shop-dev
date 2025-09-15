<div
    class="border-2 border-dashed rounded-xl p-4 bg-gray-50 dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 flex flex-col items-center justify-center space-y-2">

    {{-- Vista previa si ya existe en BD --}}
    @if($current)
    <div class="relative group">
        <img src="{{ Str::startsWith($current, 'http') ? $current : Storage::url($current) }}"
            class="w-40 h-40 object-cover rounded-lg shadow" />

        <button type="button" wire:click="$set('{{ $model }}', null)"
            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
            title="Eliminar imagen">
            <flux:icon name="x-mark" class="w-4 h-4" />
        </button>
    </div>

    {{-- Vista previa si se está subiendo --}}
    @elseif($this->$model)
    <div class="relative group">
        <img src="{{ $this->$model->temporaryUrl() }}" class="w-40 h-40 object-cover rounded-lg shadow" />

        <button type="button" wire:click="$set('{{ $model }}', null)"
            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1 shadow transition-opacity opacity-80 group-hover:opacity-100"
            title="Eliminar imagen">
            <flux:icon name="x-mark" class="w-4 h-4" />
        </button>
    </div>

    {{-- Input de carga --}}
    @else
    <label for="{{ $id }}" class="flex flex-col items-center cursor-pointer">
        <div class="flex flex-col items-center justify-center">
            <flux:icon name="cloud-arrow-up" class="w-10 h-10 text-gray-400 mb-2" />
            <span class="text-sm text-gray-600 dark:text-gray-300">Haz clic para subir una imagen</span>
            <span class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG hasta 2MB</span>
            <span class="text-xs text-gray-400">800x800px mínimo</span>
        </div>
        <input id="{{ $id }}" type="file" wire:model="{{ $model }}" class="hidden" accept="image/*">
    </label>
    @endif

    {{-- Errores --}}
    @error($model)
    <span class="text-red-600 text-xs mt-2">{{ $message }}</span>
    @enderror
</div>
