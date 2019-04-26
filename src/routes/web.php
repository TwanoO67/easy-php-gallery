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

Route::middleware('auth')->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/gallery', 'GalleryController@index')->name('gallery');
    Route::get('/gallery/{dossier}', 'GalleryController@index')->name('gallery_sub');

    Route::get('/admin', 'AdminController@list')->name('admin');
    Route::get('/admin/set/user/{id}/{bool}', 'AdminController@setAdmin');
    Route::get('/admin/delete/user/{id}', 'AdminController@deleteUser');
    Route::get('/admin/autocomplete', 'AdminController@autocomplete');

    Route::get('/albums', 'AlbumController@index')->name('albums');
    Route::get('/album/{id}', 'AlbumController@album')->name('album');
    Route::post('/album', 'AlbumController@store')->name('album_create');
    Route::post('/album/files', 'AlbumController@album_files')->name('album_files');
    Route::get('/album/delete/{id}', 'AlbumController@delete')->name('album_delete');

    Route::get('/tags', 'TagController@index')->name('tags');
    Route::get('/tags/{id}', 'TagController@tag')->name('tag');

    Route::get('/map', 'MapController@index')->name('map');



});
