@php
$alerts = [
'success' => ['color' => 'bg-green-600', 'icon' => 'M5 13l4 4L19 7'], // check
'error' => ['color' => 'bg-red-600', 'icon' => 'M6 18L18 6M6 6l12 12'], // x
'warning' => ['color' => 'bg-yellow-500', 'icon' => 'M12 9v2m0 4h.01M12 4a8 8 0 100 16 8 8 0 000-16z'], // !
'info' => ['color' => 'bg-blue-600', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z'], // i
];
@endphp

@foreach ($alerts as $type => $data)
@if (session($type))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-x-6"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-6"
    class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white text-sm {{ $data['color'] }} dark:{{ str_replace('bg-', 'bg-', $data['color']) }}"
    role="alert" style="display: none;">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $data['icon'] }}" />
    </svg>
    <span class="font-medium">{{ session($type) }}</span>
    <button @click="show = false" class="ml-auto text-white/80 hover:text-white transition">
        &times;
    </button>
</div>
@endif
@endforeach

{{-- @session('success')
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2000)" x-show="show"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
    class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg text-white bg-green-600 dark:bg-green-700 text-sm"
    role="alert" style="display: none;">
    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
    <button @click="show = false" class="ml-auto text-white/80 hover:text-white transition">
        &times;
    </button>
</div>
@endsession
 --}}

{{-- @session ('success')
<div x-data="{ show: true }" x-show="show"
    x-on:profile-updated.window="show = true; setTimeout(() => show = false, 3000)" x-transition
    class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow z-50 text-sm flex items-center"
    style="display: none;">

    <span>{{ session('success') }}</span>

    <button type="button" class="ml-4 text-white/70 hover:text-white" @click="show = false">x</button>
</div>
@endsession
--}}

{{-- <span>{{$value }}</span>
--}}

{{-- <div x-data="{ show: false }" x-show="show"
    x-on:profile-updated.window="show = true; setTimeout(() => show = false, 3000)" x-transition
    class="fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded shadow z-50 text-sm flex items-center"
    style="display: none;">

    <span>¡Perfil actualizado correctamente!</span>

    <button type="button" class="ml-4 text-white/70 hover:text-white" @click="show = false">x</button>
</div>
--}}



{{-- <div id="toast-success"
    class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
    role="alert">
    <div
        class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
        </svg>
        <span class="sr-only">Check icon</span>
    </div>
    <div class="ms-3 text-sm font-normal">Item moved successfully.</div>
    <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        data-dismiss-target="#toast-success" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div> --}}
