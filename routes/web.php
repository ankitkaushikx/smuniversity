<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

//Auth Routes
require __DIR__.'/auth.php';

//Dashboard Routes
require __DIR__ .'/dashboard.php';

//Front Routes
require __DIR__ . '/front.php';
