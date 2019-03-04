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

Route::get('/home', 'UserController@index')->name('home');
Route::get('/home/place/request', 'UserController@place_request')->name('place-request');
Route::get('/home/edit-profil', 'UserController@edit_profil')->name('edit-profil');
Route::get('/admin/home', 'AdminController@index')->name('admin-home');
