<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-md sm:text-center">
            <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl dark:text-white">Unete a
                nuestra comunidad.</h2>
            <p class="mx-auto mb-8 max-w-2xl font-light text-gray-500 md:mb-12 sm:text-xl dark:text-gray-400">Y se el
                primero en enterarte de las última novedades, lanzamientos y promociones exclusivas.</p>
            <form action="#">
                <div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                    <div class="relative w-full">
                        <label for="email"
                            class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email
                            address</label>
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                        <input
                            class="block p-3 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Enter your email" type="email" wire:model="email" id="email" required>

                    </div>
                    <div>
                       {{--  <button type="button" wire:click="subscribe" wire:loading.attr="disabled"
                            class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer
                                bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4
                                focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Subscribe
                        </button> --}}

                        <button type="button" wire:click="subscribe" wire:loading.attr="disabled"
                            class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer
                                bg-primary-700 border-primary-600 sm:rounded-none sm:rounded-r-lg hover:bg-primary-800 focus:ring-4
                                focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                <div class="flex items-center justify-center">
                            <svg wire:loading wire:target="subscribe" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <!-- Texto normal (visible solo cuando NO está cargando) -->
                            <span wire:loading.remove wire:target="subscribe">Suscribirse</span>
                            <!-- Texto alternativo mientras carga -->
                            <span wire:loading wire:target="subscribe">Procesando...</span>

                            </div>
                        </button>

                    </div>
                </div>
                <div
                    class="mx-auto max-w-screen-sm text-sm text-left text-gray-500 newsletter-form-footer dark:text-gray-300">
                    @error('email')
                    <p class="error italic text-sm  text-[#E7A022]">*{{ $message }}</p>
                    @enderror

                    We care about the protection of your data. <a href="#"
                        class="font-medium text-primary-600 dark:text-primary-500 hover:underline">Read our Privacy
                        Policy</a>.
                </div>
            </form>


            <!-- Modal Background -->
            <div x-data="{ open: @entangle('showConfirmModal') }" x-init="$watch('open')" x-show="open" style="display: none"
                class="fixed inset-0 flex items-center justify-center z-50">
                <!-- Fondo oscurecido -->
                <div class="fixed inset-0 bg-black/50"></div>

                <!-- Contenedor del modal -->
                <div class="relative mx-auto p-4 border w-120 shadow-lg rounded-md bg-white z-10">
                    <div class="mt-3 text-center">
                        <!-- Icono círculo azul -->
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-[#232BBF]">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>

                        <!-- Título -->
                        <h3 class="text-lg leading-6 font-medium mt-2 text-gray-900">Sent!</h3>

                        <!-- Mensaje -->
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">Your request has been submitted successfully.</p>
                            <p class="text-sm text-gray-500">Our team will contact you shortly.</p>
                            <p class="italic text-xs text-gray-500 mt-4">📩 Check your inbox: A copy of your request has been
                                emailed to you.</p>
                        </div>

                        <!-- Botón -->
                        <div class="items-center px-4 py-3">
                            <button type="button" wire:click="$set('showConfirmModal', false)"
                                class="inline-flex items-center text-sm font-semibold bg-gradient-to-l from-[#232BBF] to-[#2E39FF] py-2 px-12 rounded-full focus:ring-blue-700 focus:ring-2 focus:outline-none hover:cursor-pointer hover:opacity-90">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @include('components.flash-messages')
</section>
