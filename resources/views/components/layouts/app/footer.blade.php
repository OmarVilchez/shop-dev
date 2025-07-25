{{-- <flux:footer  class=" bg-black">
    <div class="container-app">
        <div class=" flex flex-col items-center md:flex-row md:justify-between ">
            <div>
                <div class=" flex justify-center">
                    <x-app-logo />
                </div>

                <div class="max-w-[400px] pl-4 text-center  md:text-start ">
                    <span class=" text-xs/2">
                    Tomatodos de acero inoxidable reutilizables. Mantiene las bebidas frías o calientes por muchas horas. Compra aquí y
                    apuesta por una hidratación sostenible.
                    </span>
                </div>
            </div>
            <div>
                <flux:navbar class="-mb-px  ml-0 xl:ml-[-8rem] space-x-2 md:space-x-8  ">
                    <flux:navbar.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        <span class="text-base"> {{ __('Home') }} </span>
                    </flux:navbar.item>
                </flux:navbar>
            </div>
            <div>
                <span class="text-base">Follow us:</span>
                <div class=" flex space-x-4 pt-4">
                    <a href="">
                        <div class=" flex justify-center items-center bg-white rounded-lg p-[8px]">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 2.91005C16.0831 1.98416 14.991 1.25002 13.7875 0.750416C12.584 0.250812 11.2931 -0.00426317 9.99 5.38951e-05C4.53 5.38951e-05 0.0800002 4.45005 0.0800002 9.91005C0.0800002 11.6601 0.54 13.3601 1.4 14.8601L0 20.0001L5.25 18.6201C6.7 19.4101 8.33 19.8301 9.99 19.8301C15.45 19.8301 19.9 15.3801 19.9 9.92005C19.9 7.27005 18.87 4.78005 17 2.91005ZM9.99 18.1501C8.51 18.1501 7.06 17.7501 5.79 17.0001L5.49 16.8201L2.37 17.6401L3.2 14.6001L3 14.2901C2.17755 12.9771 1.74092 11.4593 1.74 9.91005C1.74 5.37005 5.44 1.67005 9.98 1.67005C12.18 1.67005 14.25 2.53005 15.8 4.09005C16.5676 4.85392 17.1759 5.7626 17.5896 6.76338C18.0033 7.76417 18.2142 8.83714 18.21 9.92005C18.23 14.4601 14.53 18.1501 9.99 18.1501ZM14.51 11.9901C14.26 11.8701 13.04 11.2701 12.82 11.1801C12.59 11.1001 12.43 11.0601 12.26 11.3001C12.09 11.5501 11.62 12.1101 11.48 12.2701C11.34 12.4401 11.19 12.4601 10.94 12.3301C10.69 12.2101 9.89 11.9401 8.95 11.1001C8.21 10.4401 7.72 9.63005 7.57 9.38005C7.43 9.13005 7.55 9.00005 7.68 8.87005C7.79 8.76005 7.93 8.58005 8.05 8.44005C8.17 8.30005 8.22 8.19005 8.3 8.03005C8.38 7.86005 8.34 7.72005 8.28 7.60005C8.22 7.48005 7.72 6.26005 7.52 5.76005C7.32 5.28005 7.11 5.34005 6.96 5.33005H6.48C6.31 5.33005 6.05 5.39005 5.82 5.64005C5.6 5.89005 4.96 6.49005 4.96 7.71005C4.96 8.93005 5.85 10.1101 5.97 10.2701C6.09 10.4401 7.72 12.9401 10.2 14.0101C10.79 14.2701 11.25 14.4201 11.61 14.5301C12.2 14.7201 12.74 14.6901 13.17 14.6301C13.65 14.5601 14.64 14.0301 14.84 13.4501C15.05 12.8701 15.05 12.3801 14.98 12.2701C14.91 12.1601 14.76 12.1101 14.51 11.9901Z"
                                    fill="#2E39FF" />
                            </svg>
                        </div>
                    </a>
                    <a href="">
                        <div class=" flex justify-center items-center bg-white rounded-lg p-[9px]">
                            <svg width="17" height="17" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.8886 0.116302C18.1333 0.0133228 18.4011 -0.0221941 18.6641 0.0134478C18.9272 0.0490897 19.1759 0.154588 19.3843 0.318961C19.5928 0.483335 19.7533 0.700574 19.8493 0.948069C19.9453 1.19556 19.9733 1.46427 19.9302 1.72621L17.6846 15.347C17.4668 16.6609 16.0252 17.4143 14.8203 16.7599C13.8123 16.2124 12.3153 15.3688 10.9688 14.4886C10.2955 14.048 8.23312 12.6371 8.48659 11.6332C8.70441 10.7747 12.1698 7.54899 14.15 5.63116C14.9272 4.8777 14.5727 4.44304 13.6549 5.13611C11.3757 6.85691 7.71629 9.47374 6.50638 10.2104C5.43906 10.8599 4.88262 10.9708 4.21727 10.8599C3.00341 10.6579 1.87766 10.345 0.95885 9.96384C-0.282736 9.44899 -0.22234 7.74206 0.95786 7.24503L17.8886 0.116302Z"
                                    fill="#2E39FF" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <hr class="my-6 border-[#2E39FF] opacity-25  sm:mx-auto lg:my-4" />
        <span class="block text-sm text-gray-500 text-center dark:text-gray-400 md:pb-6">Copyright © {{ now()->year }}
            FLUYE BOTTLE S.A.C. – RUC:20602456537 | Elaborado por
        </span>
    </div>
</flux:footer>
 --}}

 <flux:footer class="bg-black text-white rounded-t-[4rem]  py-2 sm:py-8 ">
    <div class="container-app px-4 mt-8">
        <div class="flex flex-col lg:flex-row lg:justify-between md:gap-8">
            <!-- Columna 1: Información de la empresa -->
            <div class="w-full xl:max-w-[380px]">
                <div class="flex justify-center w-48 md:justify-start mb-4">
                    <x-app-logo />
                </div>
                <p class="text-sm sm:text-[15px] text-left">
                    Tomatodos de acero inoxidable reutilizables. Mantiene las bebidas frías o calientes por muchas
                    horas. Compra aquí y apuesta por una hidratación sostenible.
                </p>
                <!-- Redes Sociales -->
                <div class="flex flex-col items-center md:items-start mt-4">
                    <div class="flex space-x-4">
                        <!-- Facebook con efecto 3D -->
                        <a href="#" class="social-icon group">
                            <div
                                class="icon-container group-hover:shadow-lg group-hover:-translate-y-1 transition-all duration-300">
                                <x-icons.facebook class="text-white group-hover:scale-110 transition-transform duration-200" />
                            </div>
                        </a>

                        <!-- Instagram con efecto gradiente -->
                        <a href="#" class="social-icon group">
                            <div
                                class="icon-container group-hover:shadow-lg group-hover:-translate-y-1 transition-all duration-300">
                                <x-icons.instagram class="text-white group-hover:scale-110 transition-transform duration-200" />
                            </div>
                            {{-- <span class="icon-tooltip">Instagram</span> --}}
                        </a>

                        <!-- WhatsApp con efecto vibrante -->
                        <a href="#" class="social-icon group">
                            <div
                                class="icon-container group-hover:shadow-lg group-hover:-translate-y-1 transition-all duration-300">
                                <x-icons.whatsapp class="text-white group-hover:scale-110 transition-transform duration-200" />
                            </div>
                            {{-- <span class="icon-tooltip">WhatsApp</span> --}}
                        </a>

                        <!-- TikTok con efecto neón -->
                        <a href="#" class="social-icon group">
                            <div
                                class="icon-container group-hover:shadow-lg group-hover:-translate-y-1 transition-all duration-300">
                                <x-icons.tiktok class="text-white group-hover:scale-110 transition-transform duration-200" />
                            </div>
                            {{-- <span class="icon-tooltip">TikTok</span> --}}
                        </a>
                    </div>
                </div>
            </div>

           {{--  <!-- Columna 2: Enlaces -->
            <div class=" w-full grid grid-cols-1 md:grid-cols-3 md:gap-8 px-4 md:px-16">
                <!-- Sección 1: Envíos y Desoluciones -->
                <div>
                    <h3 class="text-xl font-black mb-4">Productos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline">Bottles</a></li>
                        <li><a href="#" class="text-sm hover:underline">Cups</a></li>
                        <li><a href="#" class="text-sm hover:underline">Mugs & Tumbler</a></li>
                        <li><a href="#" class="text-sm hover:underline">Outdoor</a></li>
                        <li><a href="#" class="text-sm hover:underline">Protein Shaker</a></li>
                        <li><a href="#" class="text-sm hover:underline">Accesorios</a></li>
                    </ul>
                </div>

                <!-- Sección 2: Productos -->
                <div>
                    <h3 class="text-xl font-black mb-4">Información</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-sm hover:underline">Política de Privacidad</a></li>
                        <li><a href="#" class="text-sm hover:underline">Política de Suscripción a Mailing</a></li>
                        <li><a href="#" class="text-sm hover:underline">Preguntas Frecuentes</a></li>
                    </ul>
                </div>

                <!-- Sección 3: Nosotros -->
                <div class="md:pl-24">
                    <h3 class="text-xl font-black mb-4">Nosotros</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline">Impacto</a></li>
                        <li><a href="#" class="text-sm hover:underline">Encuéntranos</a></li>
                        <li><a href="#" class="text-sm hover:underline">Corporativo</a></li>
                        <li><a href="#" class="text-sm hover:underline">Nosotros</a></li>
                    </ul>
                </div>
            </div> --}}

           <div class="w-full grid grid-cols-1 lg:grid-cols-3 mt-8 lg:mt-0 lg:gap-8  2xl:px-16"
            x-data="{ isMobile: window.innerWidth < 1024 }" x-init="() => {
                 const handler = () => isMobile = window.innerWidth < 1024;
                 window.addEventListener('resize', handler);
                 $el._resizeHandler = handler;
             }" x-on:destroy="window.removeEventListener('resize', $el._resizeHandler)">

            <!-- Sección 1: Productos -->
            <div class="border-b border-gray-700 lg:border-none" x-data="{ open: false }">
                <h3 class="text-xl font-black  flex justify-between items-center lg:block cursor-pointer lg:cursor-auto"
                    @click="isMobile && (open = !open)">
                    Productos
                    <svg x-show="isMobile" class="w-5 h-5 lg:hidden transition-transform duration-200"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </h3>
                <ul class="space-y-2 overflow-hidden transition-all duration-300"
                    :class="isMobile ? (open ? 'max-h-96 mt-2 mb-4 ' : 'max-h-0') : 'max-h-96'">
                    <li><a href="#" class="text-sm hover:underline">Bottles</a></li>
                    <li><a href="#" class="text-sm hover:underline">Cups</a></li>
                    <li><a href="#" class="text-sm hover:underline">Mugs & Tumbler</a></li>
                    <li><a href="#" class="text-sm hover:underline">Outdoor</a></li>
                    <li><a href="#" class="text-sm hover:underline">Protein Shaker</a></li>
                    <li><a href="#" class="text-sm hover:underline">Accesorios</a></li>
                </ul>
            </div>

            <!-- Sección 2: Información -->
            <div class="border-b border-gray-700 lg:border-none mt-4 lg:mt-0" x-data="{ open: false }">
                <h3 class="text-xl font-black  flex justify-between items-center lg:block cursor-pointer lg:cursor-auto"
                    @click="isMobile && (open = !open)">
                    Información
                    <svg x-show="isMobile" class="w-5 h-5 lg:hidden transition-transform duration-200"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </h3>
                <ul class="space-y-2 overflow-hidden transition-all duration-300"
                    :class="isMobile ? (open ? 'max-h-96 mt-2 mb-4' : 'max-h-0') : 'max-h-96'">
                    <li><a href="#" class="text-sm hover:underline">Términos y Condiciones</a></li>
                    <li><a href="#" class="text-sm hover:underline">Política de Privacidad</a></li>
                    <li><a href="#" class="text-sm hover:underline">Política de Suscripción a Mailing</a></li>
                    <li><a href="#" class="text-sm hover:underline">Preguntas Frecuentes</a></li>
                </ul>
            </div>

            <!-- Sección 3: Nosotros -->
            <div class="border-b border-gray-700 lg:border-none mt-4 lg:mt-0 2xl:pl-24" x-data="{ open: false }">
                <h3 class="text-xl font-black  flex justify-between items-center lg:block cursor-pointer lg:cursor-auto"
                    @click="isMobile && (open = !open)">
                    Nosotros
                    <svg x-show="isMobile" class="w-5 h-5 lg:hidden transition-transform duration-200"
                        :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </h3>
                <ul class="space-y-2 overflow-hidden transition-all duration-300"
                    :class="isMobile ? (open ? 'max-h-96 mt-2 mb-4' : 'max-h-0') : 'max-h-96'">
                    <li><a href="#" class="text-sm hover:underline">Impacto</a></li>
                    <li><a href="#" class="text-sm hover:underline">Encuéntranos</a></li>
                    <li><a href="#" class="text-sm hover:underline">Corporativo</a></li>
                    <li><a href="#" class="text-sm hover:underline">Nosotros</a></li>
                </ul>
            </div>
        </div>




        </div>

        <!-- Línea divisoria y copyright -->
        {{-- <hr class="my-6 border-white sm:mx-auto lg:my-8" /> --}}
        <div class="text-center text-xs text-white mt-6 lg:mt-16 border-hidden sm:border border-white">
            Copyright© 2025 FLUYE BOTTLE S.A.C. – RUC:20602456537 | Elaborado por Ecom and More
        </div>
    </div>


    {{-- <style>
        .social-icon {
            @apply relative flex flex-col items-center;
        }

        .icon-container {
            @apply w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 shadow-md;
        }

        .icon-tooltip {
            @apply absolute -bottom-7 text-xs font-medium text-white bg-gray-800 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap;
        }

        .social-icon:hover .icon-tooltip {
            animation: fadeInUp 0.3s ease-out forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(5px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
 --}}
</flux:footer>
