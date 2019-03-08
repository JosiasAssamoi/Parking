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
Route::resource('user','UserController')->only([
    'index','show','edit','update'
]);
// Si on fait un post sur la page principale c'est que l'on fait une demande de place
Route::post('user/{user}/place-request', 'UserController@place_request')->name('user.request');
Route::delete('place/{place}/place-request', 'UserController@delete_place')->name('user.delete.place');
Route::get('user/{user}/change-pass', 'UserController@change_pass_create')->name('change-pass');
Route::post('user/{user}/change-pass', 'UserController@change_pass')->name('change-pass');



//Admin routes => il faudra creer des ressources
Route::get('/admin/home', 'AdminController@index')->name('admin-home');




