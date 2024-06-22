<?php

use Illuminate\support\Facades\Route;

use Livewire\Volt\Volt;
//Dashboard routes

Route::view('/dashboard', 'livewire.pages.dashboard')->name('dashboard');