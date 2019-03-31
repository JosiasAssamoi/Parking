<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// routes d'authentification
Auth::routes();

//crée les ressources pour les demandes de places
Route::resource('booking','BookingController');

//crée les ressources pour les modification de mot passe
Route::resource('userchangepass','UserPasswordController')->only(['edit','update']);

//Demandes d'inscriptions
Route::resource('registering','RegisteringController')->only(['index','update']);

//User
Route::resource('user','UserController');
Route::get('/home','UserController@home')->name('user-home');
Route::post('user/{user}/booking-cancelled', 'UserController@booking_cancel')->name('user.cancel');

//Place 
Route::resource('place','PlaceController')->only(['index','store','update']);


//Queue
Route::resource('queue','QueueController')->only(['index','update']);

//Admin
Route::get('admin','AdminController@admin_index')->name('admin.index');
Route::post('admin/{user}/place-assignement','AdminController@assign_place')->name('admin.place-assignement');
Route::post('admin/reset-pass/user/{user}','AdminController@reset_pass')->name('admin.reset-pass');
