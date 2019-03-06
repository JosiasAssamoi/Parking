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

Auth::routes();

/* Users routes 
Route::get('/home', 'UserController@index')->name('home');
Route::get('/home/place/request', 'UserController@place_request')->name('place-request');
Route::get('/home/edit-profil/', 'UserController@create')->name('edit-profil');
Route::post('/home/edit-profil/{user}', 'UserController@update')->name('edit-profil');
*/
Route::get('user/{user}/change-pass', 'UserController@change_pass_create')->name('change-pass');
Route::post('user/{user}/change-pass', 'UserController@change_pass')->name('change-pass');

//crée les ressources du user controller avec les fonctions liées 
Route::resource('user','UserController')->only([
    'index','show','edit','update'
]);

//Admin routes => il faudra creer des ressources
Route::get('/admin/home', 'AdminController@index')->name('admin-home');




