<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Livewire\Frontend\Abouts\ContactComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

Route::get('/', HomeController::class)->name('home');


// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Volt::route('about', 'frontend/abouts/about')->name('about');
Volt::route('faqs', 'frontend/abouts/frequent-question')->name('faqs');

Route::get('contact', ContactComponent::class)->name('contact');

//Route::post('/upload-image', [ImageController::class, 'uploadImage'])->name('upload.image');


require __DIR__.'/auth.php';
