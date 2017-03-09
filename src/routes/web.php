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

Route::middleware('auth')->get('/admin', 'Admin@list');
Route::middleware('auth')->post('/folder', 'FolderController@store')->name('folder_create');


Route::get('/home', 'HomeController@index');

Route::get('/gallery/{id}', "Gallery@index");
Route::get('/gallery/{id}/{dossier}', "Gallery@index");

Route::get('/image/{id}', "Gallery@image")->name('image_raw');
