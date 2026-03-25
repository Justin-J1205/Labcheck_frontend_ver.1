<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('Authentication.login');
});

Route::get('/register', function () {
    return view('Authentication.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/inventory', function () {
    return view('Inventory.show');
});