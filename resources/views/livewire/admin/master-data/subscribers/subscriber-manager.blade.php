<section>
    @section('title')
    {{ __('Gestor de Suscripciones') }}
    @endsection

    <flux:breadcrumbs class="breadcrumbs-admin">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.master.subscribers.index')">
            {{ __('Suscripciones') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Suscripciones</h1>
        </div>

        <!-- Filtros -->
        <div class="admin-filters">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="w-full sm:max-w-lg" />
        </div>

        <!-- Tabla -->
        <div class="admin-table-container overflow-x-auto">
           <table class="admin-table">
                <thead class="admin-thead">
                   <tr>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th class="admin-th">Email</th>
                        <th class="admin-th text-center">Fecha de Registro</th>
                        <th class="admin-th text-center">Estado</th>
                        <th class="admin-th text-center">Sincronización</th>
                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="admin-tbody">
                    @forelse ( $subscriptions as $key => $subscription )
                        <tr class="admin-row">
                            <td class="admin-td">{{ $subscription->id }}</td>
                            <td class="admin-td">{{ $subscription->email }}</td>
                            <td class="admin-td text-center"> {{ $subscription->created_at->format('d-m-Y') }} </td>

                            <!-- Estado switch -->
                            <td class="admin-td text-center">
                               @switch($subscription->active)
                                    @case(0)
                                        <span class="inline-flex rounded-full px-4  font-semibold leading-5
                                                    bg-gray-300 dark:bg-zinc-600
                                                    text-gray-500 dark:text-gray-400 capitalize">
                                            {{ __('inactivo') }}
                                        </span>
                                        @break
                                    @case(1)
                                        <span class="inline-flex rounded-full px-4  font-semibold leading-5
                                                    bg-green-200 text-green-800 capitalize">
                                            {{ __('activo') }}
                                        </span>
                                        @break
                                    @default
                                @endswitch
                            </td>

                            <!-- Sincronización -->
                           <td class="admin-td text-center ">
                                @foreach ($subscription->data_sync as $key => $platform)
                                <button type="button" title="Sincronizar"
                                    wire:click="syncPlatform({{ $subscription->id }})"
                                    class="cursor-pointer inline-flex rounded-full bg-{{ $platform['sync'] ? 'green' : 'red' }}-600 px-4 text-sm font-semibold leading-5 text-{{ $platform['sync'] ? 'white' : 'white' }} capitalize">{{
                                    $key }}</button>
                                @endforeach
                            </td>


                            <!-- Acciones -->
                            <td class="admin-actions">
                                <button type="button" wire:click="changeStatus({{ $subscription->id }})"
                                    wire:loading.attr="disabled" wire:target="changeStatus"
                                    title="Cambiar Estado Sincronización"
                                    class="admin-btn admin-btn-reset">
                                    <flux:icon name="arrow-path" class="admin-icon-reset" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="admin-result-null">
                                    <span class="admin-result-text">{{ __('No se ha encontrado ningún suscriptor')}}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $subscriptions->links() }}
        </div>
    </div>

    @include('components.flash-messages')

</section>
