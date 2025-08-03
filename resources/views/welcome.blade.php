<x-layouts.app>

    @php
        $firstBanner = $banners->first();
    @endphp

    @push('head')
        @if($firstBanner)
            <link rel="preload" as="image" href="{{ $firstBanner->img_desktop }}" imagesrcset="{{ $firstBanner->img_desktop }}" media="(min-width: 769px)">
            <link rel="preload" as="image" href="{{ $firstBanner->img_mobile }}" imagesrcset="{{ $firstBanner->img_mobile }}" media="(max-width: 768px)">
        @endif
    @endpush

    <div x-data="carousel({ interval: 8000, total: {{ count($banners) }} })" x-init="start()" @mouseenter="pause()"
        @mouseleave="resume()" class="relative w-full overflow-hidden">
        <!-- Slides -->
        <div class="relative w-full">
            <template x-for="(banner, index) in banners" :key="index">
                <div x-show="current === index" x-transition:enter="transition-opacity duration-700"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="w-full"
                    :aria-hidden="current !== index">
                    <picture>
                        <source :srcset="banner.img_mobile" media="(max-width: 768px)">
                        <img :src="banner.img_desktop" alt="" class="w-full object-contain" loading="lazy"
                            @load="$el.parentElement.parentElement.classList.remove('hidden')">
                    </picture>
                    <div class="absolute left-8 bottom-8 bg-black/40 flex items-center justify-center text-center text-white p-4">
                        <div>
                            <h2 class="text-2xl md:text-4xl font-bold" x-text="banner.title"></h2>
                            <p class="text-sm md:text-lg mt-2" x-text="banner.subtitle"></p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Dots -->
        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
            <template x-for="(banner, index) in banners" :key="'dot' + index">
                <button @click="goTo(index)" :class="current === index ? 'bg-white' : 'bg-gray-500/50'"
                    class="w-3 h-3 rounded-full transition-all duration-300"></button>
            </template>
        </div>

        <!-- Prev / Next buttons -->
        <div class="absolute inset-0 flex items-center justify-between px-4 z-10">
            <button @click="prev"
                class="bg-black/40 hover:bg-black/60 text-white rounded-full w-10 h-10 flex items-center justify-center transition">
                &#8592;
            </button>
            <button @click="next"
                class="bg-black/40 hover:bg-black/60 text-white rounded-full w-10 h-10 flex items-center justify-center transition">
                &#8594;
            </button>
        </div>
    </div>





    <div class="container-app bg-blue-500">
        dsfdsfsdfdsfdsfsdfdfsdfs
    </div>



    {{-- <flux:container class="bg-amber-800">
        <span> sdasdsada </span>
    </flux:container>
    <section class="container max-w-7xl mx-auto bg-amber-500">
        home de inicio
    </section> --}}




    <div class=" flex items-center justify-center  overflow-hidden w-full">
        <!-- Contenedor del marquee infinito -->
        <div class="relative w-full overflow-hidden">
            <!-- Efecto de desenfoque en los bordes -->
          {{--   <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-black to-transparent z-10"></div>
            <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-black to-transparent z-10"></div> --}}

            <!-- Primer marquee (más grande) -->
            <div class="marquee-container py-2">
                <div class="marquee-track animate-marquee-slow">
                    <span class="kinetic-text text-6xl font-black text-black mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-black text-red-500 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-black text-gray-400 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-black text-red-300 mx-6">KIDS</span>
                    <!-- Duplicado para efecto continuo -->
                    <span class="kinetic-text text-6xl font-black text-black mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-black text-red-500 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-black text-gray-400 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-black text-red-300 mx-6">TUMBLERS</span>
                    <!-- Duplicado para efecto continuo -->
                    <span class="kinetic-text text-6xl font-black text-black mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-black text-red-500 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-black text-gray-400 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-black text-red-300 mx-6">TUMBLERS</span>
                    <!-- Duplicado para efecto continuo -->
                    <span class="kinetic-text text-6xl font-black text-black mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-black text-red-500 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-black text-gray-400 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-black text-red-300 mx-6">TUMBLERS</span>
                </div>
            </div>

            <!-- Segundo marquee (más pequeño, dirección opuesta) -->
            <div class="marquee-container py-2">
                <div class="marquee-track animate-marquee-fast-reverse">
                    <span class="kinetic-text text-6xl font-bold text-gray-500 mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-bold text-red-400 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-bold text-gray-600 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-bold text-black mx-6">DELETE</span>
                    <!-- Duplicado para efecto continuo -->
                    <span class="kinetic-text text-6xl font-bold text-gray-500 mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-bold text-red-400 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-bold text-gray-600 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-bold text-black mx-6">TUMBLERS</span>
                    <!-- Duplicado para efecto continuo -->
                    <span class="kinetic-text text-6xl font-bold text-gray-500 mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-bold text-red-400 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-bold text-gray-600 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-bold text-black mx-6">TUMBLERS</span>
                    <!-- Duplicado para efecto continuo -->
                    <span class="kinetic-text text-6xl font-bold text-gray-500 mx-6">TERMOS</span>
                    <span class="kinetic-text text-6xl font-bold text-red-400 mx-6">BOTELLAS</span>
                    <span class="kinetic-text text-6xl font-bold text-gray-600 mx-6">CUPS</span>
                    <span class="kinetic-text text-6xl font-bold text-black mx-6">TUMBLERS</span>
                </div>
            </div>
        </div>
    </div>




<div
    class="relative text-black overflow-hidden [--offset:20vw] [--move-initial:calc(-25%_+_var(--offset))] [--move-final:calc(-50%_+_var(--offset))] group">

    <div class="w-fit flex relative transform-[translate3d(var(--move-initial),0,0)] animate-marquee group-hover:[animation-play-state:paused]"
        aria-hidden="true">
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
        <span class="text-[4vw] p-[0_2vw]">Showreel</span>
    </div>

   {{--  <div class="w-fit flex relative transform-[translate3d(var(--move-initial),0,0)] animate-marquee [animation-direction:reverse] group-hover:[animation-play-state:paused]"
        aria-hidden="true">
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
    </div>

    <div class="w-fit flex relative transform-[translate3d(var(--move-initial),0,0)] animate-marquee group-hover:[animation-play-state:paused]"
        aria-hidden="true">
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
        <span class="text-[10vw] p-[0_2vw]">Showreel</span>
    </div> --}}
</div>



    {{-- empresa --}}

    <section class="container-app py-14 bg-white">
        <div class="">
            <div class="lg:flex items-center gap-x-12">

                <!-- Imagen -->
                <div class="hidden lg:block flex-1">
                    <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80"
                        alt="Service preview" class="rounded-lg max-w-full h-auto" />
                </div>

                <!-- Texto -->
                <div class="flex-1 max-w-xl lg:max-w-2xl mt-6 lg:mt-0 space-y-6">
                    <h3 class="text-indigo-600 text-sm font-semibold uppercase tracking-wide">
                        Professional services
                    </h3>
                    <h2 class="text-3xl sm:text-4xl text-gray-800 font-bold">
                        Build your SaaS solution with help from our experts
                    </h2>
                    <p class="text-gray-600">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum, sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium
                        doloremque laudantium.
                    </p>

                    <a href="#"
                        class="inline-flex items-center gap-x-1 text-indigo-600 hover:text-indigo-500 font-medium transition">
                        Learn more
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <script>
        function carousel({ interval = 8000, total = 1 }) {
                return {
                    current: 0,
                    timer: null,
                    banners: @js($banners->map(function($b) {
                        return [
                            'title' => $b->title,
                            'subtitle' => $b->subtitle,
                            'img_desktop' => $b->img_desktop,
                            'img_mobile' => $b->img_mobile
                        ];
                    })),

                    start() {
                        this.timer = setInterval(() => this.next(), interval);
                    },
                    pause() {
                        clearInterval(this.timer);
                    },
                    resume() {
                        this.start();
                    },
                    resetInterval() {
                        this.pause();
                        this.resume();
                    },
                    next() {
                        this.current = (this.current + 1) % total;
                        this.resetInterval();
                    },
                    prev() {
                        this.current = (this.current - 1 + total) % total;
                        this.resetInterval();
                    },
                    goTo(i) {
                        this.current = i;
                        this.resetInterval();
                    }
                }
            }
    </script>


</x-layouts.app>










{{-- banner antiguo --}}

{{-- <div x-data="carousel({ interval: 8000, total: {{ count($banners) }} })" x-init="start()" @mouseenter="pause()"
    @mouseleave="resume()" class="relative w-full overflow-hidden">

    <div class="relative h-[560px] md:h-[650px]">
        <template x-for="(banner, index) in banners" :key="index">
            <div x-show="current === index" x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0"
                :aria-hidden="current !== index">
                <picture>
                    <source :srcset="banner.img_mobile" media="(max-width: 768px)">
                    <img :src="banner.img_desktop" alt="" class="w-full h-full object-cover" loading="lazy">
                </picture>
                <div
                    class="absolute left-8 bottom-8 bg-black/40 flex items-center justify-center text-center text-white p-4">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-bold" x-text="banner.title"></h2>
                        <p class="text-sm md:text-lg mt-2" x-text="banner.subtitle"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>


    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-30">
        <template x-for="(banner, index) in banners" :key="'dot' + index">
            <button @click="goTo(index)" :class="current === index ? 'bg-white' : 'bg-gray-500/50'"
                class="w-3 h-3 rounded-full transition-all duration-300"></button>
        </template>
    </div>

    <div class="absolute inset-0 flex items-center justify-between px-4 z-20">
        <button @click="prev"
            class="bg-black/40 hover:bg-black/60 text-white rounded-full w-10 h-10 flex items-center justify-center transition">
            &#8592;
        </button>
        <button @click="next"
            class="bg-black/40 hover:bg-black/60 text-white rounded-full w-10 h-10 flex items-center justify-center transition">
            &#8594;
        </button>
    </div>
</div> --}}

{{-- <div x-data="carousel({ interval: 5000, total: {{ count($banners) }} })" x-init="start()" @mouseenter="pause()"
    @mouseleave="resume()" class="relative w-full overflow-hidden">
    <div class="relative h-[560px] md:h-[650px]">
        <template x-for="(banner, index) in banners" :key="index">
            <div x-show="current === index" x-transition:enter="transition-opacity duration-700"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="absolute inset-0"
                :aria-hidden="current !== index">
                <picture>
                    <source :srcset="banner.img_mobile" media="(max-width: 768px)">
                    <img :src="banner.img_desktop" alt="" class="w-full h-full object-cover" loading="lazy">
                </picture>
                <div
                    class="absolute left-8 bottom-8 bg-black/40 flex items-center justify-center text-center text-white p-4">
                    <div>
                        <h2 class="text-2xl md:text-4xl font-bold" x-text="banner.title"></h2>
                        <p class="text-sm md:text-lg mt-2" x-text="banner.subtitle"></p>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-30">
        <template x-for="(banner, index) in banners" :key="'dot' + index">
            <button @click="goTo(index)" :class="current === index ? 'bg-white' : 'bg-gray-500/50'"
                class="w-3 h-3 rounded-full transition-all duration-300"></button>
        </template>
    </div>
</div>

<script>
    function carousel({ interval = 8000, total = 1 }) {
        return {
            current: 0,
            timer: null,
            banners: @js($banners->map(function($b) {
                return [
                    'title' => $b->title,
                    'subtitle' => $b->subtitle,
                    'img_desktop' => $b->img_desktop,
                    'img_mobile' => $b->img_mobile
                ];
            })),

            start() {
                this.timer = setInterval(() => this.next(), interval);
            },
            pause() {
                clearInterval(this.timer);
            },
            resume() {
                this.start();
            },
            next() {
                this.current = (this.current + 1) % total;
            },
            goTo(i) {
                this.current = i;
                this.pause();
                this.resume();
            }
        }
    }
</script> --}}


{{-- slider --}}

{{-- <div class="relative w-full overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($banners as $banner)

        <div x-data="{ loaded: false }"
            class="relative w-full h-[300px] md:h-[400px] bg-gray-100 overflow-hidden rounded-2xl shadow">

            <div x-show="!loaded"
                class="absolute inset-0 animate-pulse bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200 z-10">
            </div>

            <img src="{{ $banner->img_desktop }}" alt="{{ $banner->title }}" loading="lazy" x-on:load="loaded = true"
                class="w-full h-full object-cover transition-opacity duration-500 ease-in-out"
                :class="{ 'opacity-100': !loaded, 'opacity-100': loaded }">


            @if ($banner->title || $banner->subtitle)
            <div
                class="absolute inset-0 bg-black/40 text-white flex flex-col justify-center items-center text-center p-4">
                <h2 class="text-xl md:text-2xl font-bold">{{ $banner->title }}</h2>
                <p class="text-sm md:text-base mt-1">{{ $banner->subtitle }}</p>
            </div>
            @endif

            @if ($banner->link_type !== 'none')
            <a href="#" class="absolute inset-0 z-20" aria-label="{{ $banner->title ?? 'Banner' }}"></a>
            @endif
        </div>
        @endforeach
    </div>
</div> --}}


{{-- <div x-data="{ tab: 'profile' }" class="mt-8">
    <div class="flex border-b mb-4">
        <button class="px-4 py-2 -mb-px border-b-2"
            :class="tab === 'profile' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
            @click="tab = 'profile'" type="button">Profile</button>
        <button class="px-4 py-2 -mb-px border-b-2"
            :class="tab === 'account' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
            @click="tab = 'account'" type="button">Account</button>
        <button class="px-4 py-2 -mb-px border-b-2"
            :class="tab === 'billing' ? 'border-blue-500 text-blue-600 font-bold' : 'border-transparent text-gray-500'"
            @click="tab = 'billing'" type="button">Billing</button>
    </div>

    <div x-show="tab === 'profile'">
        <div class="p-4 bg-white text-red-600 rounded shadow">Contenido de Profile</div>
    </div>
    <div x-show="tab === 'account'" x-cloak>
        <div class="p-4 bg-white text-red-600 rounded shadow">Contenido de Account</div>
    </div>
    <div x-show="tab === 'billing'" x-cloak>
        <div class="p-4 bg-white text-red-600 rounded shadow">Contenido de Billing</div>
    </div>
</div> --}}
