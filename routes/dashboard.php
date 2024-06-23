<?php

use Illuminate\support\Facades\Route;
use App\Http\Livewire\Dashboard\Centers;
use App\Http\Controllers\CenterController;
use App\Livewire\Dashboard\Courses;

//Dashboard routes
Route::view('/dashboard', 'livewire.pages.dashboard')->name('dashboard');

//All Dashboard Routes With Prefix

Route::prefix('dashboard')->group(function () {


  // Programs 
  Route::view('/programs', 'livewire.dashboard.programs')->name('programs');

  //Course
  Route::get('/courses',\App\Livewire\Dashboard\Courses::class)->name('courses');

  //NoticeZone
  Route::view('/noticezone', 'livewire.dashboard.noticezone')->name('noticezone');

  //Centers Management
  Route::get('/centers', \App\Livewire\Dashboard\Centers::class)->name('centers');

  //Students Management
  Route::view('/students', 'livewire.dashboard.students')->name('students');

  //Results Management
  Route::view('/results', 'livewire.dashboard.results')->name('results');
});