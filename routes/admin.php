<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
})->name('home');

Route::get('/category', function () {
    return "Hello Category";
})->name('category');
