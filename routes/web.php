<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function() {
  Route::resource('roles','RoleController');
  Route::resource('users','UserController');
  // Master
  // route menu
  Route::resource('/datagudang', 'DataGudangController');
  Route::resource('/dataitem', 'DataItemController');
  Route::resource('/dataklasifikasi', 'DataKlasifikasiController');
  Route::resource('/datamatauang', 'DataMataUangController');
  Route::resource('/datapelanggan', 'DataPelangganController');
  Route::resource('/datasatuan', 'DataSatuanController');
  Route::resource('/datasupplier', 'DataSupplierController');
  Route::resource('/datakaryawan','KaryawanController');
  Route::resource('datapelanggan', 'DataPelangganController');
  Route::resource('/datagudang', 'DataGudangController');
  Route::resource('/dataitem', 'DataItemController');
  Route::resource('/dataklasifikasi', 'DataKlasifikasiController');
  Route::resource('/datamatauang', 'DataMataUangController');
  Route::resource('/datapelanggan', 'DataPelangganController');
  Route::resource('/datasatuan', 'DataSatuanController');
  Route::resource('/datasupplier', 'DataSupplierController');
  Route::resource('/datakaryawan','KaryawanController');


  //Pembelian route
  //route pemesanan pembelian

  Route::get('/pemesananPembelian', 'PagesController@pemesananPembelian');
  Route::get('/konfirmasipemesananPembelian', 'PagesController@konfirmasiPembelian');
  Route::get('/diterimapemesananPembelian', 'PagesController@diterimaPembelian');
  Route::get('/batalpemesananPembelian', 'PagesController@batalPembelian');

  //Route::resource('/pesanpembelian', 'PemesanPembelianController');

  //route Penjualan
  //route pemesanan penjualan
  Route::get('/pemesananPenjualan', 'PemesananPenjualan@index');
  Route::get('/pemesananPenjualan/create','PemesananPenjualan@create');
  Route::get('/batalpemesananPenjualan', 'PagesController@batalPenjualan');

  //route surat jalan
  Route::get('/suratJalan', 'SuratJalanController@index');
  Route::get('/suratJalan/create/{id}','SuratJalanController@create');
  Route::post('/suratJalan/store/{id}','SuratJalanController@store');
  Route::get('/suratJalan/show/{id}','SuratJalanController@show');
  Route::get('/suratJalan/view/{id}','SuratJalanController@view');
  Route::get('/suratJalan/print/{id}','SuratJalanController@print');
  Route::post('/suratJalan/confirm/{id}','SuratJalanController@confirm');
  Route::get('/konfirmasisuratJalan', 'SuratJalanController@konfirmasiSuratJalan');

  //route return surat jalan
  Route::get('/returnSuratJalan/add/{id}', 'ReturnSuratJalanController@add');
  Route::post('/returnSuratJalan/store/{id}', 'ReturnSuratJalanController@store');
  Route::get('/returnSuratJalan', 'ReturnSuratJalanController@index');
  Route::get('/returnSuratJalan/show/{id}','ReturnSuratJalanController@show');
  Route::get('/returnSuratJalan/view/{id}','ReturnSuratJalanController@view');
  Route::post('/returnSuratJalan/print/{id}','ReturnSuratJalanController@print');
  Route::post('/returnSuratJalan/confirm/{id}','ReturnSuratJalanController@confirm');
  Route::get('/konfirmasireturnSuratJalan', 'ReturnSuratJalanController@konfirmasiSuratJalanReturn');

  //route penjualan langsung
  Route::get('/penjualanLangsung/lihat','PenjualanLangsungController@retriveData');
  Route::get('/penjualanLangsung', 'PenjualanLangsungController@index');
  Route::post('/penjualanLangsung/create', 'PenjualanLangsungController@create');
  //route return penjualan langsung
  Route::get('/returnPenjualanLangsung/{id}', 'ReturnPenjualanLangsungController@index');
  Route::post('/returnPenjualanLangsung/{id}/store', 'ReturnPenjualanLangsungController@store');

  //Pembelian route
  // route pemesananpembelian
  Route::get('/popembelian', 'PemesananPembelianController@index');
  Route::get('/pokonfirmasi', 'PemesananPembelianController@konfirmasiPembelian');
  Route::get('/poditerima', 'PemesananPembelianController@diterimaPembelian');
  Route::get('/pobatal', 'PemesananPembelianController@batalPembelian');

  //route PO
  Route::get('/popembelian/store', 'PemesananPembelianController@store');
  Route::get('/popembelian/create', 'PemesananPembelianController@create');
  Route::get('/popembelian/show/{id}', 'PemesananPembelianController@show');
  Route::get('/popembelian/lihat/{id}', 'PemesananPembelianController@lihat');
  Route::get('/popembelian/destroy/{id}', 'PemesananPembelianController@destroy');
  Route::post('/popembelian/confirm/{id}', 'PemesananPembelianController@confirm');
  Route::post('/popembelian/cancel/{id}', 'PemesananPembelianController@cancel');
  Route::post('/popembelian/print/{id}','PemesananPembelianController@print');
  Route::get('api/popembelianOPN', 'PemesananPembelianController@apiOPN')->name('api.popembelianOPN');
  Route::get('api/popembelianCFM', 'PemesananPembelianController@apiCFM')->name('api.popembelianCFM');
  Route::get('api/popembelianDEL', 'PemesananPembelianController@apiDEL')->name('api.popembelianDEL');
  Route::get('api/popembelianCLS', 'PemesananPembelianController@apiCLS')->name('api.popembelianCLS');

  //route penerimaan barang
  Route::get('/penerimaanBarang', 'PenerimaanBarangController@index');
  Route::get('/penerimaanBarang/create/{id}', 'PenerimaanBarangController@create');
  Route::post('/penerimaanBarang/store/{id}', 'PenerimaanBarangController@store');
  Route::get('/penerimaanBarang/show/{id}', 'PenerimaanBarangController@show');
  Route::get('/penerimaanBarang/lihat/{id}', 'PenerimaanBarangController@lihat');
  Route::post('/penerimaanBarang/confirm/{id}', 'PenerimaanBarangController@confirm');
  Route::post('/penerimaanBarang/cancel/{id}', 'PenerimaanBarangController@cancel');
  Route::post('/penerimaanBarang/print/{id}','PenerimaanBarangController@print');
  Route::get('/konfirmasiPenerimaanBarang', 'PenerimaanBarangController@konfirmasiPenerimaanBarang');
  Route::get('/batalPenerimaanBarang', 'PenerimaanBarangController@batalPenerimaanBarang');
  Route::get('api/penerimaanbarangOPN', 'PenerimaanBarangController@apiOPN')->name('api.penerimaanbarangOPN');
  Route::get('api/penerimaanbarangCFM', 'PenerimaanBarangController@apiCFM')->name('api.penerimaanbarangCFM');
  Route::get('api/penerimaanbarangDEL', 'PenerimaanBarangController@apiDEL')->name('api.penerimaanbarangDEL');

  //route return penerimaan barang
  Route::get('/returnPenerimaanBarang', 'ReturnPenerimaanBarangController@index');
  Route::get('/returnPenerimaanBarang/create/{id}', 'ReturnPenerimaanBarangController@create');
  Route::post('/returnPenerimaanBarang/store/{id}', 'ReturnPenerimaanBarangController@store');
  Route::get('/returnPenerimaanBarang/show/{id}', 'ReturnPenerimaanBarangController@show');
  Route::get('/returnPenerimaanBarang/lihat/{id}', 'ReturnPenerimaanBarangController@lihat');
  Route::post('/returnPenerimaanBarang/print/{id}','ReturnPenerimaanBarangController@print');
  Route::post('/returnPenerimaanBarang/confirm/{id}', 'ReturnPenerimaanBarangController@confirm');
  Route::post('/returnPenerimaanBarang/cancel/{id}', 'ReturnPenerimaanBarangController@cancel');
  Route::get('/konfirmasiReturnPenerimaanBarang', 'ReturnPenerimaanBarangController@konfirmasi');
  Route::get('/batalReturnPenerimaanBarang', 'ReturnPenerimaanBarangController@batal');
  Route::get('api/returnpenerimaanbarangOPN', 'ReturnPenerimaanBarangController@apiOPN')->name('api.returnpenerimaanbarangOPN');
  Route::get('api/returnpenerimaanbarangCFM', 'ReturnPenerimaanBarangController@apiCFM')->name('api.returnpenerimaanbarangCFM');
  Route::get('api/returnpenerimaanbarangDEL', 'ReturnPenerimaanBarangController@apiDEL')->name('api.returnpenerimaanbarangDEL');

  //route pelunasan hutang
  Route::get('/invoicehutang', 'InvoiceController@hutang');
  Route::get('/fixinvoicehutang', 'PenerimaanBarangController@fixInvoiceID');
  Route::get('/pelunasanhutang', 'PelunasanHutangController@index');
  Route::get('/pelunasanhutang/invoice/{id}', 'PelunasanHutangController@invoice');
  Route::get('/pelunasanhutang/payment/{id}', 'PelunasanHutangController@payment');
  Route::get('/pelunasanhutang/payment/{id}/add', 'PelunasanHutangController@addpayment');
  Route::post('/pelunasanhutang/payment/{id}/add', 'PelunasanHutangController@addpaymentpost');

  // route pemesananpenjualan
  Route::get('/sopenjualan', 'PemesananPenjualanController@index');
  Route::get('/filterdata', 'PemesananPenjualanController@filterData');
  //route SO
  Route::post('/sopenjualan/store', 'PemesananPenjualanController@store');
  Route::get('/sopenjualan/create', 'PemesananPenjualanController@create');
  Route::get('/sopenjualan/show/{id}','PemesananPenjualanController@show');
  Route::get('/sopenjualan/view/{id}','PemesananPenjualanController@view');
  Route::get('/sopenjualan/edit/{id}','PemesananPenjualanController@edit');
  Route::post('/sopenjualan/update/{id}','PemesananPenjualanController@update');
  Route::get('/sopenjualan/destroy/{id}', 'PemesananPenjualanController@destroy');
  Route::post('/sopenjualan/confirm/{id}', 'PemesananPenjualanController@confirm');
  Route::get('/sopenjualan/print/{id}','PemesananPenjualanController@print');

  Route::get('/konfirmasipemesananPenjualan', 'PemesananPenjualanController@konfirmasiPenjualan');
  Route::post('/konfirmasipemesananPenjualan/filter', 'PemesananPenjualanController@konfirmasiPenjualanFilter');
  Route::post('/konfirmasipemesananPenjualan/print', 'PemesananPenjualanController@konfirmasiPenjualanPrint');
  Route::get('/dikirimpemesananPenjualan', 'PemesananPenjualanController@dikirimPenjualan');

  //ROUTE STOK
  Route::get('/stokmasuk','StokMasukController@index');
  Route::get('/stokmasuk/create','StokMasukController@create');
  Route::post('/stokmasuk/store','StokMasukController@store');
  Route::get('/kartustok','KartuStokController@index');
  Route::post('/kartustok/filter','KartuStokController@filter');
  Route::post('/kartustok/print','KartuStokController@print');
  Route::get('/invoicepiutang','InvoiceController@piutang');
  Route::get('/fixinvoicepiutang','SuratJalanController@fixInvoideID');
  Route::get('/pelunasanpiutang','PelunasanController@index');
  Route::get('/pelunasanpiutang/invoice/{id}','PelunasanController@invoice');
  Route::get('/pelunasanpiutang/payment/{id}','PelunasanController@payment');
  Route::get('/pelunasanpiutang/payment/{id}/add','PelunasanController@addpayment');
  Route::post('/pelunasanpiutang/payment/{id}/add','PelunasanController@addpaymentpost');

});
