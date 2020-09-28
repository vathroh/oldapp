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


Route::get('/', function () {
    return view('landing');
});
*/

Route::get('/', 'Blog\blogController@home');

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'DashboardController@index')->name('home');
Route::resource('/profil', 'profilController');


//User Management Control
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function () {
    Route::resource('/users', 'UsersController', ['except' => ['create', 'store']]);
});


// BLOG
Route::get('/blog-osp1', 'Blog\blogController@index');
Route::get('/blog-home', 'Blog\blogController@home');
Route::get('/blog-osp1/{id}', 'Blog\blogController@show');
Route::get('/blog/post-delete/{id}/{img}/edit', 'Blog\PostController@editImage1');
Route::put('/blog/delete/{id}/{img}', 'Blog\PostController@deleteImage1');
Route::resource('/blog/post', 'Blog\PostController');
Route::resource('blog/category', 'Blog\CategoryController');
//Route::get('/blog/dashboard', 'Blog\UserController@index');


//LIBRARY
Route::get('pustaka-osp1/{library}', 'Blog\blogController@library');
Route::get('pustaka-osp1/{id}/{library}', 'Blog\blogController@single_library');
Route::resource('/pustaka', 'libraryController');
Route::get('/pustaka-file/{id}/{file}/delete', 'libraryController@deleteFile');
Route::resource('/library-category', 'libraryCategoryController');


//DOWNLOAD
Route::get('download/{folder}/{file}', 'downloadController@download');

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


// DASHBOARD
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
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
Route::get('/test', 'kppController@test');
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
Route::get('/kpp-download-rekap-kabupaten', 'kppController@exportRekapKabupaten');
Route::get('/kpp-download-rekap-kecamatan/{KD_KAB}', 'kppController@exportRekapKecamatan');
Route::get('/kpp-download-rekap-kelurahan/{KD_KEC}', 'kppController@exportRekapKelurahan');
Route::get('/rekap-data-kpp', 'kppController@rekap_all');
Route::get('/kpp-rekap-data-kecamatan/{KD_KEC}', 'kppController@rekap_kecamatan');
Route::get('/kpp-rekap-data-kelurahan/{KD_KEL}', 'kppController@rekap_kelurahan');
Route::get('/kpp-find', 'kppController@find');
Route::get('/rekap-kpp/{column}/{param}', 'kppController@rekap_item');
Route::get('/rekap-kpp/{column}/{param}/{zone}/{zone_id}', 'kppController@rekap_item_zone');
Route::get('/rekap-kpp-administrasi-tiga-bulan/{zone}/{zone_id}', 'kppController@rekap_administrasi_rutin');


//EDIT PASSWORD
Route::get('/pass-by-admin/{id}/edit', 'passwordController@admin');
Route::put('/pass-by-admin/{id}', 'passwordController@storeByAdmin');
Route::get('/pass-by-user/{id}/edit', 'passwordController@user');
Route::put('/pass-by-user/{id}', 'passwordController@storeByUser');


//ACTIVITIES : PELATIHAN | RAKOR | KBIK | EVALUASI | TES
Route::resource('/activity', 'activityController');
Route::resource('/subjects', 'subjectsController');
Route::resource('/evaluation-answers', 'evaluationAnswerController');
Route::resource('/activities-category', 'activitiesCategoryController');
Route::resource('/evaluation-questions', 'evaluationQuestionController');

Route::get('/activities', 'activityController@activities');
Route::get('/activity/{activity}', 'activityController@activity');
Route::get('/activity/{activity}/{activity_item}', 'activityController@activity_item');
Route::get('/schedule/{activity}/{activity_item}', 'activityController@schedule');
Route::get('/lesson/{activity}/{activity_item}', 'activityController@lesson');
Route::get('/attendance/{activity}/{activity_item}', 'activityController@attendance');
Route::post('/records-attendance/{activity}/{activity_item}', 'activityController@records_attendance');
Route::get('/lesson-download/{library_id}', 'activityController@lesson_download');
Route::get('/training-evaluation/{activity_id}/{subject_id}', 'evaluationController@index');
Route::get('/activity-evaluation/{activity_id}', 'evaluationController@activityEvaluation');
Route::get('/dropdown-question', 'evaluationAnswerController@dropdown');
Route::get('/certificate_page/{activity}/{activity_item}', 'activityController@certificate_page');
Route::post('/certificate', 'activityController@certificate');
Route::get('/listing-attendant/{activity}/{activity_item}', 'activityController@listing_attendant');
Route::get('/training-monitoring/{activity}/{activity_item}', 'activityController@monitoring');
Route::get('/participants/{activity}/{activity_item}', 'activityController@participants');

Route::get('/ajax-listing-attendant-find-name/', 'activityController@ajaxAttendanceFindName');
Route::get('/ajax-listing-attendant/', 'activityController@ajaxAttendance');
Route::post('/ajax-listing-register/', 'activityController@ajaxRegister');
Route::get('/ajax-listing-ready', 'activityController@ready');
Route::get('/ajax-listing-moveReg', 'activityController@moveReg');
Route::delete('/ajax-listing-delete', 'activityController@deleteAjax');

Route::post('/training-evaluation/{activity_id}/{subject_id}', 'evaluationController@store');
Route::post('/activity-evaluation/{activity_id}', 'evaluationController@evaluationActivityStore');
