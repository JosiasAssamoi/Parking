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



//crée les ressources du user controller avec les fonctions liées
Route::resource('user','UserController');
Route::get('/home','UserController@home')->name('user-home');
// Si on fait un post sur la page principale c'est que l'on fait une demande de place
Route::post('user/{user}/place-request', 'UserController@place_request')->name('user.request');
Route::delete('place/{place}/place-request', 'UserController@delete_booking')->name('user.delete.place');
Route::get('user/{user}/change-pass', 'UserController@change_pass_create')->name('change-pass');
Route::post('user/{user}/change-pass', 'UserController@change_pass')->name('change-pass');
Route::post('user/{user}/booking-cancelled', 'UserController@booking_cancel')->name('user.cancel');

//Place routes => il faudra creer des ressources
Route::resource('place','PlaceController');
//Admin routes
Route::get('admin','AdminController@admin_index')->name('admin.index');
Route::get('admin/edit-register-requests','AdminController@edit_register_requests')->name('admin.edit-register-requests');
Route::patch('admin/edit-register-requests/{user}','AdminController@edit_register_requests')->name('admin.valid-register-requests');
Route::get('admin/edit-queue','AdminController@edit_queue')->name('admin.edit-queue');
Route::patch('admin/valid-queue','AdminController@valid_queue')->name('admin.valid-queue');
Route::get('admin/edit-users','AdminController@edit_users')->name('admin.edit-users');
Route::get('admin/show-res','AdminController@show_res')->name('admin.show-res');
Route::post('admin/{user}/place-assignement','AdminController@assign_place')->name('admin.place-assignement');
Route::post('admin/reset-pass/user/{user}','AdminController@reset_pass')->name('admin.reset-pass');
