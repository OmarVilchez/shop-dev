@php
$links = [
[
'name' => 'Home',
'icon' => 'layout-grid',
'url' => route('home'),
'current' => request()->routeIs('home'),
],
];

$leftLinks = [
['name' => 'HOME', 'url' => '/'],
['name' => 'PRODUCTOS', 'url' => '#', 'dropdown' => true],
['name' => 'SALE 🎉', 'url' => '#'],
['name' => 'CORPORATIVO', 'url' => '#'],
];

$rightLinks = [
    [
    'name' => 'NOSOTROS',
    'route' => 'about'
    ],
    [
    'name' => 'CONTACTO',
    'route' => 'contact'
    ],
    [
    'name' => 'FAQ',
    'route' => 'faqs'
    ],
    ];
@endphp



{{-- <flux:header class=" border-b border-zinc-700 bg-black text-white"> --}}

    <div class="fixed top-0 left-0 w-full z-50">
        <!-- Barra superior -->
        <div class="relative bg-red-600 text-white overflow-hidden h-[40px] flex items-center [--offset:20vw] [--move-initial:calc(-25%_+_var(--offset))] [--move-final:calc(-50%_+_var(--offset))] group">
            <div class="w-fit flex relative transform-[translate3d(var(--move-initial),0,0)] animate-marquee group-hover:[animation-play-state:paused]"
                aria-hidden="true">
                @for ($i = 0; $i < 10; $i++) <span class="whitespace-nowrap text-xs font-medium px-[2vw]"> ¡ENVÍO GRATIS A TODO EL PERÚ EN
                    PEDIDOS DESDE S/199!</span>
                    @endfor
            </div>
        </div>

        <flux:header class="border-b border-zinc-700 bg-black text-white">
            <div class="w-full max-w-[90%] mx-auto flex py-2 items-center">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

                <div class="flex w-full items-center justify-between">

                    {{-- Menú izquierdo --}}
                    <div class="flex items-center gap-6 max-lg:hidden">
                        @foreach ($leftLinks as $link)
                        @if (!empty($link['dropdown']))
                        <flux:dropdown>
                            <flux:button variant="ghost" class="font-bold uppercase text-sm">
                                {{ $link['name'] }}
                                <svg class="w-3 h-3 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7" />
                                </svg>
                            </flux:button>
                            <flux:menu>
                                {{-- Aquí puedes poner subitems del dropdown --}}
                                <flux:menu.radio.group>
                                    <flux:menu.item href="#">Termos</flux:menu.item>
                                    <flux:menu.item href="#">Tomatodos</flux:menu.item>
                                    <flux:menu.item href="#">Accesorios</flux:menu.item>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>
                        @else
                        <a href="{{ $link['url'] }}"
                            class="font-bold uppercase whitespace-nowrap text-sm hover:opacity-80 transition-all duration-150">
                            {{ $link['name'] }}
                        </a>
                        @endif
                        @endforeach
                    </div>

                    <flux:navbar class="-mb-px max-lg:hidden">
                        {{-- @foreach ($links as $link)
                        <flux:navbar.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']"
                            wire:navigate>
                            {{ __($link['name']) }}
                        </flux:navbar.item>
                        @endforeach --}}
                        <a href="{{ route('home') }}"
                            class="w-32  ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0"
                            wire:navigate>
                            <x-app-logo />
                        </a>
                    </flux:navbar>

                    {{-- Menú derecho --}}
                    <div class="flex items-center gap-6 max-lg:hidden">
                        @foreach ($rightLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            class="font-bold uppercase text-sm hover:opacity-80 transition-all duration-150">
                            {{ $link['name'] }}
                        </a>
                        @endforeach

                        <flux:spacer />

                        <!-- Desktop User Menu -->
                        {{-- <button type="button" @click="openSearch = !openSearch" class=" ">
                            <span class="sr-only">Search</span>
                            <svg class="h-8 p-1 hover:text-theme-purple duration-200" aria-hidden="true"
                                focusable="false" data-prefix="far" data-icon="search" role="img"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                class="svg-inline--fa fa-search fa-w-16 fa-9x">
                                <path fill="currentColor"
                                    d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z">
                                </path>
                            </svg>
                        </button> --}}


                        <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                            <flux:tooltip position="bottom">
                                <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#"
                                    :label="__('Search')" />
                            </flux:tooltip>
                            <flux:tooltip position="bottom">
                                <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="shopping-bag" href="#"
                                    target="_blank" :label="__('Cart')" />
                            </flux:tooltip>


                            <!-- Solo si está autenticado -->
                            @auth
                            <flux:dropdown position="top" align="end">
                                <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />
                                {{--
                                <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="user"
                                    :initials="auth()->user()->initials()" /> --}}


                                <flux:menu>
                                    <flux:menu.radio.group>
                                        <div class="p-0 text-sm font-normal">
                                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                                    <span
                                                        class="flex h-full w-full items-center justify-center rounded-lg   bg-neutral-700 text-white">
                                                        {{ auth()->user()->initials() }}
                                                    </span>
                                                </span>

                                                <div class="grid flex-1 text-start text-sm leading-tight">
                                                    <span class="truncate font-semibold">{{ auth()->user()->name
                                                        }}</span>
                                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </flux:menu.radio.group>

                                    <flux:menu.separator />

                                    @if(auth()->check() && auth()->user()->roles()->count() > 0)
                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('manager.dashboard')" icon="home" wire:navigate>
                                            {{ __('Manager Dashboard') }}
                                        </flux:menu.item>
                                    </flux:menu.radio.group>

                                    <flux:menu.separator />
                                    @endif

                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{
                                            __('Settings')
                                            }}
                                        </flux:menu.item>
                                    </flux:menu.radio.group>

                                    <flux:menu.separator />

                                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                                        @csrf
                                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle"
                                            class="w-full">
                                            {{ __('Log Out') }}
                                        </flux:menu.item>
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                            @else
                            <flux:dropdown position="top" align="end">
                                <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="user"
                                    aria-label="{{ __('User menu') }}" />
                                <flux:menu>
                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('login')" wire:navigate>
                                            {{ __('Login') }}
                                        </flux:menu.item>

                                        <flux:menu.item :href="route('register')" wire:navigate>
                                            {{ __('Register') }}
                                        </flux:menu.item>

                                    </flux:menu.radio.group>
                                </flux:menu>
                            </flux:dropdown>
                            @endauth

                        </flux:navbar>

                    </div>

                </div>


            </div>

        </flux:header>

    </div>

    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-black z-50">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('home') }}" class="w-24 ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')">
                {{-- <flux:navlist.item icon="layout-grid" :href="route('dashboard')"
                    :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item> --}}
                @foreach ($links as $link)
                <flux:navbar.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>
                    {{ __($link['name']) }}
                </flux:navbar.item>
                @endforeach

            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist>
    </flux:sidebar>


    {{--
    </body>

    </html> --}}




    {{-- {{ $slot }} --}}

    {{-- @fluxScripts --}}
