<x-layouts.app.header :title="$title ?? null" />


<flux:main>
    {{ $slot }}
</flux:main>


@fluxScripts
