<?php

return [

    'Catálogo' => [
        [
            'name' => 'Categorías',
            'icon' => 'view-columns',
            'route' => 'manager.catalog.categories.index',
            'can' => 'listar categorias',
        ],
        [
            'name' => 'Cantidades',
            'icon' => 'square-3-stack-3d',
            'route' => 'manager.catalog.quantities.index',
            'can' => 'listar cantidades',
        ],
        [
            'name' => 'Colecciones',
            'icon' => 'rectangle-stack',
            'route' => 'manager.catalog.collections.index',
            'can' => 'listar colecciones',
        ],
        [
            'name' => 'Especificaciones',
            'icon' => 'clipboard-document',
            'route' => 'manager.catalog.specifications.index',
            'can' => 'listar especificaciones',
        ],
        [
            'name' => 'Productos',
            'icon' => 'cube',
            'route' => 'manager.catalog.products.index',
            'can' => 'listar productos',
        ],
        [
            'name' => 'Promociones',
            'icon' => 'tag',
            'route' => 'manager.catalog.promotions.index',
            'can' => 'listar promociones',
        ],
    ],

    'Contenidos' => [
        [
            'name' => 'Anuncios',
            'icon' => 'megaphone',
            'route' => 'manager.content.announcements.index',
            'can' => 'listar anuncios',
        ],
        [
            'name' => 'Blog',
            'icon' => 'newspaper',
            'route' => 'manager.content.blog.index',
            'can' => 'listar blog',
        ],
        [
            'name' => 'Cotizaciones',
            'icon' => 'receipt-percent',
            'route' => 'manager.content.quotes.index',
            'can' => 'listar cotizaciones',
        ],
        [
            'name' => 'FAQs',
            'icon' => 'question-mark-circle',
            'route' => 'manager.content.faqs.index',
            'can' => 'listar faqs',
        ],
        [
            'name' => 'Banners',
            'icon' => 'banknotes',
            'route' => 'manager.content.banners.index',
            'can' => 'listar banners',
        ],
    ],

    'MasterData' => [
        [
            'name' => 'Contactos',
            'icon' => 'chat-bubble-bottom-center-text',
            'route' => 'manager.master.contacts.index',
            'can' => 'listar contactos',
        ],
        [
            'name' => 'Clientes',
            'icon' => 'user',
            'route' => 'manager.master.clients.index',
            'can' => 'listar clientes',
        ],
        [
            'name' => 'Suscriptores',
            'icon' => 'envelope',
            'route' => 'manager.master.subscribers.index',
            'can' => 'listar suscriptores',
        ],
    ],

    'Cuentas' => [
        [
            'name' => 'Permisos',
            'icon' => 'shield-check',
            'route' => 'manager.accounts.permissions.index',
            'can' => 'listar permisos',
        ],
        [
            'name' => 'Roles',
            'icon' => 'user-group',
            'route' => 'manager.accounts.roles.index',
            'can' => 'listar roles',
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'users',
            'route' => 'manager.accounts.users.index',
            'can' => 'listar usuarios',
        ],
    ],
];
