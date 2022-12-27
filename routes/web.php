<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('el/', 'ElController@index')->name('el');
Route::get('el-meteringpoint/', 'ElController@indexMeteringPoint')->name('el-meteringpoint');
Route::get('el-charges/', 'ElController@indexCharges')->name('el-charges');
Route::get('el-spotprices/', 'ElController@indexSpotprices')->name('el-spotprices');
Route::get('consumption/', 'ElController@indexConsumption')->name('consumption');
Route::get('el-totalprices/', 'ElController@indexTotalPrices')->name('el-totalprices');
Route::get('el-custom/', 'ElController@indexCustomUsage')->name('el-custom');
Route::post('processdata', 'ElController@processData');
Route::post('getMeteringPointData', 'ElController@getMeteringPointData');
Route::post('getChargesForWeb', 'ElController@getChargesForWeb');
Route::post('getSpotprices', 'ElController@getSpotprices');
Route::post('getConsumption', 'ElController@getConsumption');
Route::post('getTotalPrices', 'ElController@getTotalPrices');
Route::post('processcustom', 'ElController@processCustom');


require __DIR__.'/auth.php';
