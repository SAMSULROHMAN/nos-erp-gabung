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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('gudang','DataGudangController@getDataGudang')->name('gudang');
Route::get('stok', 'KartuStokController@api')->name('stok');
Route::get('invoice','InvoiceController@getPiutangData')->name('api.invoice');
Route::get('/popembelianOPN', 'PemesananPembelianController@apiOPN')->name('api.popembelianOPN');
Route::get('api/popembelianCFM', 'PemesananPembelianController@apiCFM')->name('api.popembelianCFM');
Route::get('api/popembelianDEL', 'PemesananPembelianController@apiDEL')->name('api.popembelianDEL');
Route::get('api/popembelianCLS', 'PemesananPembelianController@apiCLS')->name('api.popembelianCLS');
