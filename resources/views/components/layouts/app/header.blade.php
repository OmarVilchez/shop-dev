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
['name' => 'ZERO', 'url' => '#'],
['name' => 'PRODUCTOS', 'url' => '#', 'dropdown' => true],
['name' => 'SALE 🎉', 'url' => '#'],
['name' => 'CORPORATIVO', 'url' => '#'],
];

$rightLinks = [
['name' => 'IMPACTO', 'url' => '#'],
['name' => 'CONÓCENOS', 'url' => '#'],
['name' => 'COFFEE CORNERS', 'url' => '#'],
];
@endphp
<flux:header class=" border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-black">

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
                <flux:navbar.item :icon="$link['icon']" :href="$link['url']" :current="$link['current']" wire:navigate>
                    {{ __($link['name']) }}
                </flux:navbar.item>
                @endforeach --}}
                <a href="{{ route('home') }}"
                    class="w-32  ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                    <x-app-logo />
                </a>
            </flux:navbar>

            {{-- Menú derecho --}}
            <div class="flex items-center gap-6 max-lg:hidden">
                @foreach ($rightLinks as $link)
                    <a href="{{ $link['url'] }}"
                        class="font-bold uppercase text-sm hover:opacity-80 transition-all duration-150">
                        {{ $link['name'] }}
                    </a>
                @endforeach

                <flux:spacer />

                <!-- Desktop User Menu -->
                <!-- Solo si está autenticado -->
                @auth
                <flux:dropdown position="top" align="end">
                    <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

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

                        @if(auth()->check() && auth()->user()->roles()->count() > 0)
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('manager.dashboard')" icon="home" wire:navigate>
                                {{ __('Manager Dashboard') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />
                        @endif

                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings')
                                }}
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
                @else
                <flux:dropdown position="top" align="end">
                    <flux:button class="cursor-pointer" icon="user" aria-label="{{ __('User menu') }}" />
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
            </div>

        </div>


    </div>
</flux:header>

<!-- Mobile Menu -->
<flux:sidebar stashable sticky
    class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('home') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
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
        <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
            {{ __('Repository') }}
        </flux:navlist.item>

        <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
            {{ __('Documentation') }}
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>


{{--
</body>

</html> --}}




{{-- {{ $slot }} --}}

{{-- @fluxScripts --}}
