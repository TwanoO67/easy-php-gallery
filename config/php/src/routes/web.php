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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin', 'Admin@list');

    Route::post('/folder', 'FolderController@store')->name('folder_create');
    Route::get('/folder/delete/{id}', 'FolderController@delete')->name('folder_delete');

    Route::get('/admin/autocomplete', 'Admin@autocomplete');

    Route::get('/gallery/{id}', "Gallery@index");
    Route::get('/gallery/{id}/{dossier}', "Gallery@index");

});


Route::get('/home', 'HomeController@index');
