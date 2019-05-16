<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/scan/start', 'APIController@scan_start')->name('scan_start');
Route::get('/scan/status', 'APIController@scan_status')->name('scan_status');
Route::post('/file/upload', 'APIController@file_upload')->name('file_upload');

Route::post('/storage/create', 'StorageController@create')->name('storage_create');
Route::post('/storage/delete', 'StorageController@delete')->name('storage_delete');


Route::post('/album/files', 'AlbumController@album_files')->name('album_files');



