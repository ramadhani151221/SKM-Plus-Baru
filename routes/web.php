<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/faq', [App\Http\Controllers\HomeController::class, 'faq'])->name('faq');
Route::get('/about-me', [App\Http\Controllers\HomeController::class, 'aboutme'])->name('aboutme');
Route::get('admin/home', [App\Http\Controllers\HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


// User
Route::group(['as' => 'user.','prefix' => 'akun'], function () {
    Route::get('{id}/show', '\App\Http\Controllers\UserController@show')->name('show');
    Route::get('{id}/edit', '\App\Http\Controllers\UserController@edit')->name('edit');
    Route::post('{id}/edit', '\App\Http\Controllers\UserController@update')->name('update');
    Route::get('{id}/ganti-password', '\App\Http\Controllers\UserController@passEdit')->name('passEdit');
    Route::post('{id}/ganti-password', '\App\Http\Controllers\UserController@passUpdate')->name('passUpdate');
});

// Distributor
Route::get('distributor/', [\App\Http\Controllers\DistributorController::class, 'index'])->name('distributor.index')->middleware('is_admin');

// Produk
Route::group(['as' => 'katalog.','prefix' => 'produk'], function () {
    Route::get('/admin', '\App\Http\Controllers\KatalogController@index')->name('index')->middleware('is_admin');
    Route::get('/create', '\App\Http\Controllers\KatalogController@create')->name('create')->middleware('is_admin');
    Route::post('/create', '\App\Http\Controllers\KatalogController@store')->name('store')->middleware('is_admin');
    Route::get('{id}/show', '\App\Http\Controllers\KatalogController@show')->name('show');
    Route::get('{id}/edit', '\App\Http\Controllers\KatalogController@edit')->name('edit')->middleware('is_admin');
    Route::post('{id}/edit', '\App\Http\Controllers\KatalogController@update')->name('update')->middleware('is_admin');
});

// Order
Route::group(['as' => 'order.','prefix' => 'order'], function () {
    Route::get('/', '\App\Http\Controllers\OrderController@index')->name('index');
    Route::get('{id}/{cabang}/create', '\App\Http\Controllers\OrderController@create')->name('create');
    Route::post('{id}/{cabang}/create', '\App\Http\Controllers\OrderController@store')->name('store');
    Route::get('{id}/show', '\App\Http\Controllers\OrderController@show')->name('show');
    Route::get('warning', '\App\Http\Controllers\OrderController@warning')->name('warning'); 
});

//Transaksi
Route::group(['as' => 'transaksi.','prefix' => 'transaksi'], function () {
    Route::get('/', '\App\Http\Controllers\TransaksiController@index')->name('user.index');
    Route::get('/admin', '\App\Http\Controllers\TransaksiController@indexAdmin')->name('admin.indexAdmin')->middleware('is_admin');
    Route::get('{id}/show', '\App\Http\Controllers\TransaksiController@show')->name('user.show');
    Route::get('{id}/invoice', '\App\Http\Controllers\TransaksiController@invoice')->name('user.invoice');
    Route::get('{id}/showAdmin', '\App\Http\Controllers\TransaksiController@showAdmin')->name('admin.showAdmin')->middleware('is_admin');
    Route::post('{id}/konfirmasi', '\App\Http\Controllers\TransaksiController@update')->name('admin.update')->middleware('is_admin');
});

// Cabang
Route::group(['as' => 'cabang.','prefix' => 'cabang'], function () {
    Route::get('/', '\App\Http\Controllers\CabangController@index')->name('index')->middleware('is_admin');
    Route::get('{id}/show', '\App\Http\Controllers\CabangController@show')->name('show')->middleware('is_admin');
});

//Stock
Route::group(['as' => 'stock.','prefix' => 'stok'], function () {
    Route::get('/', '\App\Http\Controllers\StockController@index')->name('index')->middleware('is_admin');
    Route::get('{id}/list', '\App\Http\Controllers\StockController@list')->name('list');
    Route::get('{id}/create', '\App\Http\Controllers\StockController@create')->name('create');
    Route::post('{id}/create', '\App\Http\Controllers\StockController@store')->name('store');
    Route::get('{id}/show', '\App\Http\Controllers\StockController@show')->name('show');
    Route::get('{id}/edit', '\App\Http\Controllers\StockController@edit')->name('edit');
    Route::post('{id}/edit', '\App\Http\Controllers\StockController@update')->name('update');
});

// Artikel
Route::group(['as' => 'artikel.','prefix' => 'artikel'], function () {
    Route::get('/', '\App\Http\Controllers\ArtikelController@index')->name('user.index');
    Route::get('/admin', '\App\Http\Controllers\ArtikelController@indexAdmin')->name('admin.index')->middleware('is_admin');
    Route::get('/create', '\App\Http\Controllers\ArtikelController@create')->name('admin.create')->middleware('is_admin');
    Route::post('/create', '\App\Http\Controllers\ArtikelController@store')->name('admin.store')->middleware('is_admin');
    Route::get('{id}/show', '\App\Http\Controllers\ArtikelController@show')->name('user.show');
    Route::get('{id}/edit', '\App\Http\Controllers\ArtikelController@edit')->name('admin.edit')->middleware('is_admin');
    Route::post('{id}/edit', '\App\Http\Controllers\ArtikelController@update')->name('admin.update')->middleware('is_admin');
});
Route::get('{id}/show', '\App\Http\Controllers\ArtikelController@showAdmin')->name('artikel.admin.show')->middleware('is_admin');

// Pengeluaran
Route::group(['as' => 'finance.','prefix' => 'finance'], function () {
    Route::get('/pengeluaran', '\App\Http\Controllers\FinanceController@index')->name('expenses.index')->middleware('is_admin');
    Route::get('pengeluaran/{id}/list', '\App\Http\Controllers\FinanceController@list')->name('expenses.list')->middleware('is_admin');
    Route::get('/pengeluaran/create/{id}', '\App\Http\Controllers\FinanceController@create')->name('expenses.create')->middleware('is_admin');
    Route::post('/pengeluaran/create/{id}', '\App\Http\Controllers\FinanceController@store')->name('expenses.store')->middleware('is_admin');
    Route::get('/pengeluaran/{id}/show', '\App\Http\Controllers\FinanceController@show')->name('expenses.show');
    Route::get('/pengeluaran/{id}/edit', '\App\Http\Controllers\FinanceController@edit')->name('expenses.edit')->middleware('is_admin');
    Route::post('/pengeluaran/{id}/edit', '\App\Http\Controllers\FinanceController@update')->name('expenses.update')->middleware('is_admin');

    // Rekap Keuangan
    Route::get('/rekap', '\App\Http\Controllers\ReportController@index')->name('report.index')->middleware('is_admin');
    Route::get('cabang/{id}', '\App\Http\Controllers\ReportController@cabang')->name('report.cabang')->middleware('is_admin');
    Route::post('cabang/{id}', '\App\Http\Controllers\ReportController@cabangPeriode')->name('report.cabangPeriode')->middleware('is_admin');
    Route::get('/recap', '\App\Http\Controllers\ReportController@recap')->name('report.recap')->middleware('is_admin');
    Route::post('/recap', '\App\Http\Controllers\ReportController@recapPeriode')->name('report.recapPeriode')->middleware('is_admin');
});