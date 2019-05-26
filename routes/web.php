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

Route::prefix('')->group(function () {
    Route::get('/', 'ItemController@index')->name('items.index');
    Route::post('/', 'ItemController@store')->name('items.store');
    Route::delete('/{item}', 'ItemController@destroy')->name('items.destroy');
    Route::post('/{id}/edit', 'ItemController@update')->name('items.update');
});
