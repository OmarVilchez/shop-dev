<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Hello Admin";
})->name('home');

Route::get('/category', function () {
    return "Hello Category";
})->name('category');
