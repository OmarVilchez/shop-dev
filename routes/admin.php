<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect()->route('home');
// })->name('home');




// Route::get('/', function () {
//     return redirect()->route('home');
// })->middleware('can:home');


// Route::view('dashboard', 'dashboard')
//     ->middleware('can:home');

Route::view('dashboard', 'dashboard')
    ->middleware('can:home')
    ->name('dashboard');


Route::resource('categories', CategoryController::class)->middleware('can:listar categorias');
