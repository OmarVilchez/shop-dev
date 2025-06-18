<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Livewire\Admin\Categories\CategoryManager;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect()->route('home');
// })->name('home');




// Route::get('/', function () {
//     return redirect()->route('home');
// })->middleware('can:home');


// Route::view('dashboard', 'dashboard')
//     ->middleware('can:home');


// INICIO
Route::view('dashboard', 'dashboard')->middleware('can:home')->name('dashboard');

// CATALOGOS
Route::get('catalog/categories', CategoryManager::class)->middleware('can:listar categorias')->name('catalog.categories.index');
