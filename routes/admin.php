<?php


use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Panel\Dashboard;
use App\Livewire\Admin\Panel\Orders\OrderManager;
use App\Livewire\Admin\Catalog\Categories\CategoryManager;
use App\Livewire\Admin\Catalog\Collections\CollectionManager;
use App\Livewire\Admin\Catalog\Products\ProductManager;
use App\Livewire\Admin\Catalog\Promotions\PromotionManager;
use App\Livewire\Admin\Catalog\Quantities\QuantityManager;
use App\Livewire\Admin\Catalog\Specifications\SpecificationManager;
use App\Livewire\Admin\Content\Announcements\AnnouncementManager;
use App\Livewire\Admin\Content\Blog\BlogManager;
use App\Livewire\Admin\Content\Faqs\FaqManager;
use App\Livewire\Admin\Content\Quotes\QuoteManager;
use App\Livewire\Admin\Content\Sliders\SliderManager;
use App\Livewire\Admin\Accounts\Permissions\PermissionManager;
use App\Livewire\Admin\Accounts\Roles\RoleManager;
use App\Livewire\Admin\Accounts\Users\UserManager;
use App\Livewire\Admin\MasterData\Clients\ClientManager;
use App\Livewire\Admin\MasterData\Contacts\ContactManager;
use App\Livewire\Admin\MasterData\Subscribers\SubscriberManager;


// INICIO
Route::view('dashboard', 'dashboard')->middleware('can:home')->name('dashboard');
//Route::get('dashboard', Dashboard::class)->middleware('can:home')->name('dashboard');

// ORDENES
Route::get('orders', OrderManager::class)->middleware('can:listar ordenes')->name('orders.index');

// CATALOGOS
Route::get('catalog/categories', CategoryManager::class)->middleware('can:listar categorias')->name('catalog.categories.index');
Route::get('catalog/collections', CollectionManager::class)->middleware('can:listar colecciones')->name('catalog.collections.index');
Route::get('catalog/products', ProductManager::class)->middleware('can:listar productos')->name('catalog.products.index');
Route::get('catalog/promotions', PromotionManager::class)->middleware('can:listar promociones')->name('catalog.promotions.index');
Route::get('catalog/quantities', QuantityManager::class)->middleware('can:listar cantidades')->name('catalog.quantities.index');
Route::get('catalog/specifications', SpecificationManager::class)->middleware('can:listar especificaciones')->name('catalog.specifications.index');

// CONTENIDOS
Route::get('content/announcements', AnnouncementManager::class)->middleware('can:listar anuncios')->name('content.announcements.index');
Route::get('content/blog', BlogManager::class)->middleware('can:listar blog')->name('content.blog.index');
Route::get('content/faqs', FaqManager::class)->middleware('can:listar faqs')->name('content.faqs.index');
Route::get('content/quotes', QuoteManager::class)->middleware('can:listar cotizaciones')->name('content.quotes.index');
Route::get('content/sliders', SliderManager::class)->middleware('can:listar sliders')->name('content.sliders.index');

// CUENTAS
Route::get('accounts/permissions', PermissionManager::class)->middleware('can:listar permisos')->name('accounts.permissions.index');
Route::get('accounts/roles', RoleManager::class)->middleware('can:listar roles')->name('accounts.roles.index');
Route::get('accounts/users', UserManager::class)->middleware('can:listar usuarios')->name('accounts.users.index');

// MASTER DATA
Route::get('master/contacts', ContactManager::class)->middleware('can:listar contactos')->name('master.contacts.index');
Route::get('master/clients', ClientManager::class)->middleware('can:listar clientes')->name('master.clients.index');
Route::get('master/subscribers', SubscriberManager::class)->middleware('can:listar suscriptores')->name('master.subscribers.index');

// LOGS
Route::get('logs', function () {})->middleware('can:listar logs')->name('logs.index');





// Route::get('/', function () {
//     return redirect()->route('home');
// })->name('home');

// Route::get('/', function () {
//     return redirect()->route('home');
// })->middleware('can:home');

// Route::view('dashboard', 'dashboard')
//     ->middleware('can:home');
