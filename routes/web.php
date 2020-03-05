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
});


Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'DocumentsController@index')->name('home');

//User Management Control
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function () {
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
});

Route::get('/doc', 'DocumentsController@index');
Route::get('/table', 'DocumentsController@table');
Route::get('/create', 'DocumentsController@create');
Route::get('/ksm', 'DocumentsController@ksm');
Route::get('/foto', 'DocumentsController@foto');
Route::get('/rekap', 'RekapController@index');
Route::get('/rekapKab', 'RekapController@rekapKab');
Route::get('/rekapKel/{kabupaten}', 'RekapController@rekapKel');
Route::get('/rekapKSM/{kelurahan}', 'RekapController@rekapKSM');
Route::get('/rekapKegiatan/{KSM}', 'RekapController@rekapKegiatan');

// Route::get('/doc/{document}', 'DocumentsController@show');
Route::get('/drop', 'VillagesController@index');

Route::get('/ajax', 'VillagesController@kab');
Route::get('/ajaxkab', 'VillagesController@ksm_kab');
Route::get('/ajaxksm', 'VillagesController@ksm_ksm');
Route::get('/ajaxfotoksm', 'VillagesController@foto_ksm');
Route::get('/ajaxfoto', 'VillagesController@fotokab');
Route::get('/ajaxfotokegiatan', 'VillagesController@fotokegiatan');
Route::get('/dokumen', 'VillagesController@jenisDokumen');

Route::get('/dashboard', 'DashboardController@index');
Route::get('/inputyear', 'DashboardController@create');
Route::get('/coba', 'DashboardController@coba');

Route::post('/inputyear', 'DashboardController@store');
Route::post('/drop', 'VillagesController@kab');
Route::post('/doc', 'DocumentsController@store');
Route::post('/ksm', 'DocumentsController@storeKSM');
Route::post('/foto', 'DocumentsController@storeFoto');
