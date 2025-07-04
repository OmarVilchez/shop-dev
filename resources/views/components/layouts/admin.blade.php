@php
$groups = [
'Plataform' => [
[
'name' => 'Dashboard',
'icon' => 'home',
'url' => route('manager.dashboard'),
'current' => request()->routeIs('manager.dashboard'),
],
[
'name' => 'Categorias',
'icon' => 'funnel',
'url' => route('manager.catalog.categories.index'),
'current' => request()->routeIs('manager.catelog.categories.*'),
],
],
];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    {{-- @include('partials.head') --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Alertify CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/alertify/alertify.min.css') }}?v={{ time() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <!-- Styles -->
    @livewireStyles

</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable
        class="w-56 border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('manager.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse"
            wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            @foreach ($groups as $group => $links)
            <flux:navlist.group :heading="__($group)" class="grid">
                @foreach ($links as $link)
                <flux:navlist.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>
                    {{
                    __($link['name']) }}
                </flux:navlist.item>
                @endforeach
            </flux:navlist.group>
            @endforeach
        </flux:navlist>

        {{-- <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist> --}}


        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:button as="a" href="{{ url('/') }}" color="primary" class="ml-2">
            Ir a la web
        </flux:button>

        {{-- <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown> --}}
    </flux:header>

    <flux:main>
        {{ $slot }}
    </flux:main>

    @include('components.flash-messages')

    @fluxScripts

    @livewireScripts

    <!-- Alertify JS -->
    <script src="{{ asset('assets/js/alertify/alertify.min.js') }}?v={{ time() }}"></script>

    <script>
        window.addEventListener('DOMContentLoaded', (event) => {

                        window.Livewire.on('show-alert', ({ title, message }) => {
                            alertify.notify(message ?? title, 'success', 5);
                        });

                        window.Livewire.on('confirm-alert', (msgTitle, msgConfirm, idItem, method) => {
                            alertify.confirm(msgTitle, msgConfirm,
                                function() {
                                    // window.Livewire.emit('deleteSkuConfirm',idItem);
                                    window.Livewire.emit(method, idItem);
                                }, //boton ok
                                function() {
                                    return;
                                } //boton cancelar
                            );
                        });
                    });

                    window.Components = {},
                        window.Components.sidebar = function() {
                            return {
                                openMenu: false,
                                init() {
                                    if (window.innerWidth <= 768) {
                                        this.openMenu = false
                                    } else {
                                        this.openMenu = true
                                    }
                                },
                                show() {
                                    this.openMenu = true
                                },
                                close() {
                                    this.openMenu = false
                                }
                            }
                        }
                    window.Components.accordion = function() {
                        return {
                            selected: null
                        }
                    }
    </script>

</body>

</html>
