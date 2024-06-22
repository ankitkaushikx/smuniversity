<?php

use Illuminate\support\Facades\Route;



//Dashboard routes
Route::view('/dashboard', 'livewire.pages.dashboard')->name('dashboard');

//All Dashboard Routes With Prefix

Route::prefix('dashboard')->group(function () {


  // Programs 
  Route::view('/programs', 'livewire.dashboard.programs')->name('programs');

  //Course
  Route::view('/courses', 'livewire.dashboard.courses')->name('courses');

  //NoticeZone
  Route::view('/noticezone', 'livewire.dashboard.noticezone')->name('noticezone');

  //Centers Management
  Route::view('/centers', 'livewire.dashboard.centers')->name('centers');

  //Students Management
  Route::view('/students', 'livewire.dashboard.students')->name('students');

  //Results Management
  Route::view('/results', 'livewire.dashboard.results')->name('results');
});