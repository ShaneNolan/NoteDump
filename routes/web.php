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
Route::get('/', 'NoteController@index');

Route::post('/', 'NoteController@store');

Route::get('/{id}/{key}', 'NoteController@get');

Route::post('/delete', 'NoteController@destroy');
