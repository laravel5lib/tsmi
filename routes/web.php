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

Route::get('/', 'NewsController@index')->name('index');
Route::get('/news/{group}', 'NewsController@show')->name('show');
Route::get('/link/{article}', 'NewsController@link')->name('link');
Route::get('/load/{type}/{id}', 'NewsController@load');