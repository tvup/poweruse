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
})->name('home');

Route::get('el/', 'ElController@index')->name('el');
Route::get('el-meteringpoint/', 'ElController@indexMeteringPoint')->name('el-meteringpoint');
Route::get('el-charges/', 'ElController@indexCharges')->name('el-charges');
Route::post('processdata', 'ElController@processData');
Route::post('getMeteringPointData', 'ElController@getMeteringPointData');
Route::post('getChargesForWeb', 'ElController@getChargesForWeb');

