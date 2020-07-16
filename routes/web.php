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
    return redirect('/post');
});

Route::get('/post','PostController@index')->name('post');
Route::get('/post/download','PostController@download')->name('post-download');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
