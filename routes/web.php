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
    return redirect('el');
})->name('home');

Route::get('el/', 'ElController@index')->name('el');
Route::get('el-meteringpoint/', 'ElController@indexMeteringPoint')->name('el-meteringpoint');
Route::get('el-charges/', 'ElController@indexCharges')->name('el-charges');
Route::get('el-spotprices/', 'ElController@indexSpotprices')->name('el-spotprices');
Route::get('consumption/', 'ElController@indexConsumption')->name('consumption');
Route::get('el-totalprices/', 'ElController@indexTotalPrices')->name('el-totalprices');
Route::post('processdata', 'ElController@processData');
Route::post('getMeteringPointData', 'ElController@getMeteringPointData');
Route::post('getChargesForWeb', 'ElController@getChargesForWeb');
Route::post('getSpotprices', 'ElController@getSpotprices');
Route::post('getConsumption', 'ElController@getConsumption');
Route::post('getTotalPrices', 'ElController@getTotalPrices');

