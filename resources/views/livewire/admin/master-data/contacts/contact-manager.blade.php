<section>
    @section('title')
    {{ __('Gestor de Contactos') }}
    @endsection

    <flux:breadcrumbs class="breadcrumbs-admin">
        <flux:breadcrumbs.item :href="route('manager.dashboard')">
            {{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('manager.master.contacts.index')">
            {{ __('Contactos') }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

   <div class="admin-section">

        <!-- Título y botón -->
        <div class="admin-header">
            <h1 class="admin-title">Contactos</h1>
        </div>

        <!-- Filtros -->
        <div class="admin-filters">
            <flux:input type="text" wire:model.live="search" placeholder="Buscar..." class="admin-filter-input" />
        </div>

        <!-- Tabla -->
        <div class="admin-table-container overflow-x-auto">
            <table class="admin-table">
                <thead class="admin-thead">
                    <tr>
                        <th class="admin-th cursor-pointer" wire:click="sortBy('id')">#</th>
                        <th class="admin-th cursor-pointer group" wire:click="sortBy('name')">
                            <span class="flex items-center">
                                Nombre
                                <flux:icon
                                    name="{{ $sortField === 'name' ? ($sortDirection === 'asc' ? 'arrow-down' : 'arrow-up') : 'arrow-down' }}"
                                    class="h-3 w-3 ml-2 {{ $sortField !== 'name' ? 'invisible group-hover:visible group-focus:visible' : '' }}" />
                            </span>
                        </th>
                        <th class="admin-th cursor-pointer group" wire:click="sortBy('email')">
                            <span class="flex items-center">
                                Email
                                <flux:icon
                                    name="{{ $sortField === 'email' ? ($sortDirection === 'asc' ? 'arrow-down' : 'arrow-up') : 'arrow-down' }}"
                                    class="h-3 w-3 ml-2 {{ $sortField !== 'email' ? 'invisible group-hover:visible group-focus:visible' : '' }}" />
                            </span>
                        </th>
                        <th class="admin-th">Nro Celular</th>
                        <th class="admin-th">Motivo</th>
                        <th class="admin-th">Mensaje</th>
                        <th class="admin-th cursor-pointer text-center group" wire:click="sortBy('created_at')">
                            <span class="flex items-center">
                                Fecha de Registro
                                <flux:icon
                                    name="{{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? 'arrow-down' : 'arrow-up') : 'arrow-down' }}"
                                    class="h-3 w-3 ml-2 {{ $sortField !== 'created_at' ? 'invisible group-hover:visible group-focus:visible' : '' }}" />
                            </span>
                        </th>
                        <th class="admin-th text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="admin-tbody">
                    @forelse ( $contacts as $key => $contact )
                    <tr class="admin-row">
                        <td class="admin-td">{{ $contact->id }}</td>
                        <td class="admin-td max-w-[150px]">{{ $contact->name }}</td>
                        <td class="admin-td">{{ Str::limit($contact->email, 25) }}</td>
                        <td class="admin-td">{{ $contact->phone_number }}</td>
                        <td class="admin-td max-w-[200px]">{{ Str::limit($contact->subject, 30) }}</td>
                        <td class="admin-td max-w-[200px]">{{ Str::limit($contact->message, 30) }}</td>
                        <td class="admin-td text-center"> {{ $contact->created_at->format('d-m-Y') }} </td>

                        <!-- Acciones -->
                        <td class="admin-actions">
                            @can('listar contactos')
                                <button wire:click="viewContact({{ $contact->id }})" class="admin-btn admin-btn-edit" title="Ver Información">
                                    <flux:icon name="eye" class="admin-icon-edit" />
                                </button>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="admin-result-null">
                               <span class="admin-result-text">{{ __('No se ha encontrado ningun contacto')}}</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{ $contacts->links() }}
        </div>
    </div>

  <!-- Modal para Información de Contacto -->
    <flux:modal wire:model="showModalViewContact" variant="flyout">
        <div class="space-y-6">
            <!-- Título -->
            <flux:heading size="lg">{{ __('Información de Contacto') }}</flux:heading>

            <!-- Componentes -->
            <div>
                <flux:input label="Nombre" id="name" wire:model.defer="name" disabled />
            </div>

            <div>
                <flux:input label="Email" id="email" wire:model.defer="email" disabled />
            </div>

            <div>
                <flux:input label="Celular" id="phone_number" wire:model.defer="phone_number" disabled />
            </div>

            <div>
                <flux:input label="Motivo" id="subject" wire:model.defer="subject" disabled />
            </div>

            <div>
                <flux:textarea label="Mensaje" id="message" wire:model.defer="message" disabled />
            </div>

            <!-- Acciones -->
            <div class="flex space-x-4">
                <flux:spacer />
                <flux:button type="button" color="zinc" wire:click="$set('showModalViewContact', false)">
                    {{ __('Cancelar') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>



</section>
