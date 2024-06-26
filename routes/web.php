<?php

use App\Http\Controllers\Auth\ApiAccessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmartMeController;
use App\Http\Middleware\VerifyCsrfToken;
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
Auth::routes();

Route::get('/', function () {
    return redirect('home');
})->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/privacy', [App\Http\Controllers\HomeController::class, 'privacy'])->name('privacy');
Route::get('/build/manifest.webmanifest', [App\Http\Controllers\WebManifestController::class, 'manifest']);

Route::middleware('locale')->group(function () {
    // Routes that requires auth
    Route::middleware('protected.routes')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/create-api-access', [ApiAccessController::class, 'create'])->name('api.create');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/smartme', [SmartMeController::class, 'update'])->name('smartme.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Routes that does NOT require auth
    Route::get(
        '/totalprices',
        App\Http\Controllers\TotalPricesController::class
    )->name('totalprices');

    Route::post(
        'totalprices',
        App\Http\Controllers\TotalPrices\ProcessController::class,
    )->withoutMiddleware([VerifyCsrfToken::class])->name('totalprices.process');

    Route::get('el/', 'ElController@index')->name('el');
    Route::get('el-meteringpoint/', 'MeteringPointController@index')->name('el-meteringpoint');
    Route::get('el-charges/', 'ChargeController@index')->name('el-charges');
    Route::get('el-spotprices/', 'ElController@indexSpotprices')->name('el-spotprices');
    Route::get('consumption/', 'ElController@indexConsumption')->name('consumption');
    Route::get('el-custom/', 'ElController@indexCustomUsage')->name('el-custom');
    Route::post('processdata', 'ElController@processData');
    Route::post('getMeteringPointData', 'ElController@getMeteringPointData');
    Route::post('getSpotprices', 'ElController@getSpotprices');
    Route::post('getConsumption', 'ElController@getConsumption');
    Route::post('getTotalPrices', 'ElController@getTotalPrices');
    Route::post('processcustom', 'ElController@processCustom');
});
require __DIR__ . '/auth.php';
