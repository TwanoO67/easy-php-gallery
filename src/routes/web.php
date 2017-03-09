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

Route::get('/home', 'HomeController@index');

Route::get('/gallery', "Gallery@index");

Route::get('/image/{id}', "Gallery@image")->name('image_raw');

Route::get('/disk', function () {

    //lister les disk
    //dd(config('filesystems.disks'));
    $directory = "/";

    dd(Storage::disk('dockervolume')->files($directory));
});
