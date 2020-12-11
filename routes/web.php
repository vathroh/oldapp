<?php

/*
|------------------------------------------------------------------------------------------------------------------------------------------
| Web Routes
|------------------------------------------------------------------------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These'
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
    Route::get('users-index', 'UsersController@ajaxIndex');
});

Route::get('hrm', 'hrmController@index');

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

Route::get('/kpp-download-foto-pengecekan-fisik/{id}', 'kppController@downloadFotoPengecekanFisik');


//KPP Monitoring
Route::get('/kpp-monitoring', 'kppController@monitoring');
Route::get('/kpp-spot-check', 'kppController@spotCheck');
Route::get('/kpp-maintenance', 'kppController@maintenance');
Route::get('/kpp-bop', 'kppController@bop');
Route::get('/kpp-meeting', 'kppController@meeting');
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

//KPP Ajax
Route::get('/kppkecamatan', 'dropdownController@kecamatan');
Route::get('/kppkelurahan', 'dropdownController@kelurahan');
Route::get('/searchindexkpp', 'kppController@searchIndex');


//EDIT PASSWORD
Route::get('/pass-by-admin/{id}/edit', 'passwordController@admin');
Route::put('/pass-by-admin/{id}', 'passwordController@storeByAdmin');
Route::get('/pass-by-user/{id}/edit', 'passwordController@user');
Route::put('/pass-by-user/{id}', 'passwordController@storeByUser');


//ACTIVITIES : PELATIHAN | RAKOR | KBIK | EVALUASI | TES
Route::resource('/activity', 'activityController');
Route::resource('/subjects', 'subjectsController');
Route::get('/activities', 'activityController@activities');
Route::get('/activity/{activity}', 'activityController@activity');
Route::resource('/evaluation-answers', 'evaluationAnswerController');
Route::resource('/activity-blacklist', 'activityBlacklistController');
Route::resource('/activities-category', 'activitiesCategoryController');
Route::get('/dropdown-question', 'evaluationAnswerController@dropdown');
Route::resource('/evaluation-questions', 'evaluationQuestionController');
Route::get('/lesson/{activity}/{activity_item}', 'activityController@lesson');
Route::post('/certificate/{activity_item}', 'activityController@certificate');
Route::get('/lesson-download/{library_id}', 'activityController@lesson_download');
Route::get('/schedule/{activity}/{activity_item}', 'activityController@schedule');
Route::get('/attendance/{activity}/{activity_item}', 'activityController@attendance');
Route::get('/activity/{activity}/{activity_item}', 'activityController@activity_item');
Route::get('/participants/{activity}/{activity_item}', 'activityController@participants');
Route::get('/training-evaluation/{activity_id}/{subject_id}', 'evaluationController@index');
Route::get('/activity-evaluation/{activity_id}', 'evaluationController@activityEvaluation');
Route::post('/training-evaluation/{activity_id}/{subject_id}', 'evaluationController@store');
Route::get('/training-monitoring/{activity}/{activity_item}', 'activityController@monitoring');
Route::post('/records-attendance/{activity}/{activity_item}', 'activityController@records_attendance');
Route::get('/listing-attendant/{activity}/{activity_item}', 'activityController@listing_attendant');
Route::get('/evaluation-result/{activity}/{activity_item}', 'activityController@evaluation_result');
Route::post('/activity-evaluation/{activity_id}', 'evaluationController@evaluationActivityStore');
Route::get('/certificate_page/{activity}/{activity_item}', 'activityController@certificate_page');
Route::get('/evaluation-check/{activity}/{activity_item}', 'activityController@evaluation_check');
//Ajax
Route::get('/ajax-listing-attendant-find-registered-name/', 'activityController@ajaxAttendanceFindRegisteredName');
Route::get('/ajax-listing-attendant-find-name/', 'activityController@ajaxAttendanceFindName');
Route::get('/ajax-listing-registered-attendant/', 'activityController@ajaxRegisteredAttendance');
Route::get('/ajax-evaluation-result', 'activityController@ajaxEvaluationResult');
Route::get('/ajax-listing-attendant/', 'activityController@ajaxAttendance');
Route::post('/ajax-listing-register/', 'activityController@ajaxRegister');
Route::delete('/ajax-listing-delete', 'activityController@deleteAjax');
Route::get('/ajax-listing-moveReg', 'activityController@moveReg');
Route::get('/ajax-listing-ready', 'activityController@ready');



//EVALUASI KINERJA 
Route::resource('personnel-evaluator', 'personnelEvaluation\evaluator');
Route::resource('personnel-evaluation', 'personnelEvaluation\evaluation');
Route::resource('personnel-evaluation-setup', 'personnelEvaluation\setup');
Route::resource('personnel-evaluation-aspect', 'personnelEvaluation\aspect');
Route::resource('personnel-evaluation-criteria', 'personnelEvaluation\criteria');

Route::get('personnel-evaluation-upload/{valueId}', 
    'personnelEvaluation\upload@evidencePage');
Route::post('personnel-evaluation-upload/{valueId}', 
    'personnelEvaluation\upload@evidence');
Route::delete('personnel-evaluation-upload/{valueId}', 
    'personnelEvaluation\upload@destroy');
Route::get('personnel-evaluation-download-rekap-all', 'personnelEvaluation\download@rekapAll');

Route::get('personnel-evaluation-rekap', 'personnelEvaluation\evaluation@rekap');
Route::put('personnel-evaluation-setup-ready/{id}', 'personnelEvaluation\setup@ready');
Route::get('personnel-evaluation-edit',  'personnelEvaluation\evaluation@editPermission');
Route::get('personnel-evaluation-monitoring',  'personnelEvaluation\evaluation@monitoring');
Route::put('personnel-evaluation-setup-aspect/{id}', 'personnelEvaluation\setup@saveAspect');
Route::put('personnel-evaluation-setup-not-ready/{id}', 'personnelEvaluation\setup@notReady');
Route::put('personnel-evaluation-edit-grant/{valueId}',  'personnelEvaluation\evaluation@editGrant');
Route::get('personnel-evaluation-setup/{quarter}/{year}/{id}', 'personnelEvaluation\setup@store');
Route::put('personnel-evaluation-value-ready/{valueId}',  'personnelEvaluation\evaluation@ready');
Route::put('personnel-evaluation-edit-denied/{id}',  'personnelEvaluation\evaluation@editDenied');
Route::get('personnel-evaluation-home/{district}/{jobId}/{evaluasi}', 'personnelEvaluation\evaluation@home');
Route::post('personnnel-evaluation-index', 'personnelEvaluation\setup@setupIndex')->name('setupIndex');
Route::get('personnel-evaluation-create/{settingId}/{userId}',  'personnelEvaluation\evaluation@input');
Route::put('personnel-evaluation-value-not-ready/{valueId}',  'personnelEvaluation\evaluation@notReady');
Route::put('personnel-evaluation-value-ready-user/{userId}', 'personnelEvaluation\evaluation@userReady');
Route::put('personnel-evaluation-edit-grant-user/{id}',  'personnelEvaluation\evaluation@userEditGrant');
Route::put('personnel-evaluation-edit-denied-user/{id}',  'personnelEvaluation\evaluation@userEditDenied');
Route::get('personnel-evaluation-input/{settingId}/{userId}',  'personnelEvaluation\evaluation@inputValue');
Route::get('personnel-evaluation-download/{settingId}/{userId}',  'personnelEvaluation\evaluation@download');
Route::put('personnel-evaluation-value-not-ready-user/{valueId}',  'personnelEvaluation\evaluation@userNotReady');
Route::get('personnel-evaluation-setup-copy/{settingId}', 'personnelEvaluation\setup@copy');
Route::get('personnel-evaluation-myevaluation', 'personnelEvaluation\evaluation@myevaluation');
Route::get('personnel-evaluation-monitoring-extend/{evaluation}/{jobId}', 'personnelEvaluation\evaluation@extendedMonitoring');
Route::get('personnel-evaluation-download-file/{fileId}', 'personnelEvaluation\upload@download');
//Ajax
Route::get('personnel-evaluation-setup-aspect-item-move-down', 'personnelEvaluation\setup@moveDownAspectItem');
Route::get('personnel-evaluation-setup-aspect-item-move-up', 'personnelEvaluation\setup@moveUpAspectItem');
Route::get('personnel-evaluation-setup-aspect-item-delete', 'personnelEvaluation\setup@deleteAspectItem');
Route::get('personnel-evaluation-setup-aspect-move-save', 'personnelEvaluation\setup@moveSaveAspect');
Route::get('personnel-evaluation-setup-aspect-move-down', 'personnelEvaluation\setup@moveDownAspect');
Route::get('personnel-evaluation-setup-aspect-move-up', 'personnelEvaluation\setup@moveUpAspect');
Route::get('personnel-evaluation-setup-aspect-delete', 'personnelEvaluation\setup@deleteAspect');
Route::get('personnnel-evaluation-getJobTitles', 'personnelEvaluation\setup@ajaxJobTitles');
Route::get('personnel-evaluator-select', 'personnelEvaluation\evaluator@getEvaluator');
Route::get('personnel-evaluation-user-create', 'personnelEvaluation\evaluation@userCreate');
Route::get('personnel-evaluation-home', 'personnelEvaluation\evaluation@ajaxHome');
Route::get('search-aspect-id', 'personnelEvaluation\setup@ajaxAspect');
Route::get('ajax-personnel-evaluation-upload', 'personnelEvaluation\upload@ajaxUploadFile');

//GIS
Route::resource('gis', 'gis\gisController');
