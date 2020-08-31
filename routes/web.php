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
    return view('landing');
});


Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'kppController@index')->name('home');
Route::resource('/profil', 'profilController');



//User Management Control
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function () {
    Route::resource('/users', 'UsersController', ['except' => ['create', 'store']]);
});


Route::get('/blog/dashboard', 'Blog\UserController@index');

Route::get('/doc', 'DocumentsController@index');
Route::get('/table', 'DocumentsController@table');
// Route::get('/create', 'DocumentsController@create');
Route::get('/bkm', 'DocumentsController@create');
Route::get('/ksm', 'DocumentsController@ksm');
Route::get('/foto', 'DocumentsController@foto');
Route::get('/upload', 'DocumentsController@upload');

Route::get('/docbkm', 'DocumentsController@docbkm');
Route::post('/uploaddoc', 'DocumentsController@uploaddoc');


// Vue Depemndent List
Route::get('/tahun', 'DocumentsController@years');
Route::get('/kabupaten', 'DocumentsController@kabupaten');
// Route::get('/kelurahan/{regency}', 'DocumentsController@kelurahan');

Route::get('/rekap', 'RekapController@index');

//Rekap Foto ==
Route::get('/rekapKab', 'RekapController@rekapKab');
Route::get('/rekapKel/{kabupaten}', 'RekapController@rekapKelCentang');
Route::get('/rekapKSM/{kelurahan}', 'RekapController@rekapKSMCentang');
Route::get('/rekapKegiatan/{KSM}', 'RekapController@rekapKegiatanCentang');
Route::get('/rekapKegiatanCentang/{kegiatan}', 'RekapController@jmlKegiatanKSM');

//Rekap KSM
Route::get('/rekapdokumenksm', 'rekapKSMController@ksmKab');

//Rekap BKM
Route::get('/rekapdokumenbkm', 'rekapBKMController@bkmKab');

// Rekap foto
Route::get('/viewfotokegiatan={kegiatan}', 'fotoviewController@kegiatan');

// Kurang Upload foto
Route::get('/kurangupload', 'kuranguploadController@index');
Route::post('/kurangupload', 'kuranguploadController@perkegiatan');

// Route::get('/doc/{document}', 'DocumentsController@show');
Route::get('/drop', 'VillagesController@index');

Route::get('/ajax', 'VillagesController@kab');
Route::get('/ajaxkab', 'VillagesController@ksm_kab');
Route::get('/ajaxksm', 'VillagesController@ksm_ksm');
Route::get('/ajaxfotoksm', 'VillagesController@foto_ksm');
Route::get('/ajaxfototahun', 'VillagesController@tahunFOTO');
Route::get('/ajaxfoto', 'VillagesController@fotokab');
Route::get('/ajaxfotokegiatan', 'VillagesController@fotokegiatan');
Route::get('/dokumen', 'VillagesController@jenisDokumen');


//KPP Dropdown
Route::get('/kppkecamatan', 'dropdownController@kecamatan');
Route::get('/kppkelurahan', 'dropdownController@kelurahan');

Route::get('/dashboard', 'DashboardController@index');
Route::get('/inputyear', 'DashboardController@create');
Route::get('/coba', 'DashboardController@coba');

// Rekrutmen
Route::get('/pengumuman-rekrutmen-2020', 'BinakarirController@index');
Route::get('/contact', 'BinakarirController@contact');

Route::post('/inputyear', 'DashboardController@store');
Route::post('/drop', 'VillagesController@kab');
Route::post('/bkm', 'DocumentsController@store');
Route::post('/ksm', 'DocumentsController@storeKSM');
Route::post('/foto', 'DocumentsController@storeFoto');

//KPP
Route::resource('/kpp', 'kppController');
Route::resource('/kpp/struktur-organisasi', 'kpp\strukturOrganisasiController');
Route::resource('/kpp/anggaran-dasar', 'kpp\anggaranDasarController');
Route::resource('/kpp/anggaran-rumah-tangga', 'kpp\anggaranRumahTanggaController');
Route::resource('/kpp/surat-keputusan', 'kpp\suratKeputusanController');
Route::resource('/kpp/rencana-kerja', 'kpp\rencanaKerjaController');
Route::resource('/kpp/pertemuan-rutin', 'kpp\pertemuanRutinController');
Route::resource('/kpp/administrasi-rutin', 'kpp\administrasiRutinController');
Route::resource('/kpp/buku-inventaris-kegiatan', 'kpp\bukuInventarisKegiatanController');
Route::resource('/kpp/biaya-operasional', 'kpp\biayaOperasionalController');
Route::resource('/kpp/pengecekan-fisik', 'kpp\pengecekanFisikController');
Route::resource('/kpp/kegiatan-pemeliharaan-fisik', 'kpp\kegiatanPemeliharaanFisikController');
Route::resource('/kpp/keterangan-lain-lain', 'kpp\keteranganLainController');
Route::resource('/kpp/pengurus', 'kpp\penguruskppController');
Route::resource('kpp/data-pertemuan', 'kpp\DataPertemuanController');
Route::resource('/kpp/data-bop', 'kpp\kppOperatingFundController');
Route::resource('/kpp/data-pengecekan-fisik', 'kpp\dataPengecekanFisikController');
Route::get('/kpp-download-excel', 'kppController@export');
Route::get('/rekap-data-kpp', 'kppController@rekap_all');
Route::get('/kpp-rekap-data-kecamatan/{KD_KEC}', 'kppController@rekap_kecamatan');
Route::get('/kpp-rekap-data-kelurahan/{KD_KEL}', 'kppController@rekap_kelurahan');

