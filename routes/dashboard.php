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
  Route::get('/programs', \App\Livewire\Dashboard\Programs::class)->name('programs');

  //Course
  Route::get('/courses', \App\Livewire\Dashboard\Courses::class)->name('courses');

  //NoticeZone
  Route::get('/noticezone', \App\Livewire\Dashboard\Noticezone::class)->name('noticezone');

  //Centers Management
  Route::get('/centers', \App\Livewire\Dashboard\Centers::class)->name('centers');

  //Students Management
  Route::get('/students', \App\Livewire\Dashboard\Students::class)->name('students');
  //All Students 
  Route::get('/students/all', \App\Livewire\Dashboard\StudentsAll::class)->name('students.all');

  //Results Management
  Route::get('/results', \App\Livewire\Dashboard\Results::class)->name('results');
});