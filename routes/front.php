<?php

use Illuminate\Support\Facades\Route;

//This Route is for Front End Pages ;

//Home 
Route::view('/', 'home')->name('home');
// About Us Page
Route::view('/about', 'pages.about')->name('about');

//Recognition Page
Route::view('/recognition', 'pages.recognition')->name('recognition');

//Download Page
Route::view('/download', 'pages.download')->name('download');

//Student Zone
Route::view('/studentzone', 'pages.studentzone')->name('studentzone');

//Faculty
Route::view('/faculty', 'pages.faculty')->name('faculty');

//Contact Us page 
Route::view('contact', 'pages.contact')->name('contact');